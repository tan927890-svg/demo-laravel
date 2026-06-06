"""
chatbot.py — Auto X Showroom AI Chatbot
──────────────────────────────────────────
Provider: Groq (primary) → Gemini (fallback)
  - Primary      : llama-3.3-70b-versatile  (tool calling, chat)
  - Groq fallback: llama-3.1-8b-instant → llama3-70b-8192 → mistral-small-2503
  - Gemini backup: gemini-2.0-flash-lite → gemini-2.0-flash  (khi Groq hết quota)
  - Vision       : meta-llama/llama-4-scout-17b-16e-instruct → Gemini vision
"""

import os
import re
import json
import logging
from typing import Dict, List, Optional, Tuple
from datetime import datetime
from pathlib import Path

from groq import Groq, RateLimitError, BadRequestError
from google import genai
from google.genai import types
from google.api_core.exceptions import ResourceExhausted
from pydantic import BaseModel, Field
from dotenv import load_dotenv
from sqlalchemy.orm import Session

from database import SessionLocal
from models import Car, CarVariant, CarColor, CarSpec, CarFeature

load_dotenv()

# ─── Logging ──────────────────────────────────────────────────────────────────
logger = logging.getLogger(__name__)
logger.setLevel(logging.INFO)
_fmt = logging.Formatter("%(asctime)s - %(levelname)s - %(message)s")
_fh  = logging.FileHandler("chatbot.log", encoding="utf-8")
_fh.setFormatter(_fmt)
_sh  = logging.StreamHandler()
_sh.setFormatter(_fmt)
try:
    _sh.stream.reconfigure(encoding="utf-8")
except Exception:
    pass
logger.addHandler(_fh)
logger.addHandler(_sh)
logger.propagate = False

# ─── Session file ─────────────────────────────────────────────────────────────
_SESSION_FILE         = Path("sessions.json")
_MAX_SESSION_MESSAGES = 30


def _load_all_sessions() -> Dict:
    try:
        if _SESSION_FILE.exists():
            return json.loads(_SESSION_FILE.read_text(encoding="utf-8"))
    except Exception as e:
        logger.error(f"Load sessions error: {e}")
    return {}


def _save_all_sessions(data: Dict) -> None:
    try:
        _SESSION_FILE.write_text(
            json.dumps(data, ensure_ascii=False, indent=2),
            encoding="utf-8",
        )
    except Exception as e:
        logger.error(f"Save sessions error: {e}")


# ─── Conversation state ───────────────────────────────────────────────────────
class Conversation(BaseModel):
    messages: List[Dict] = Field(default_factory=list)
    last_interaction: str = Field(default_factory=lambda: datetime.now().isoformat())


# ─── Tool definitions — Groq format (OpenAI-compatible) ──────────────────────
GROQ_TOOLS = [
    {
        "type": "function",
        "function": {
            "name": "list_cars",
            "description": (
                "Lấy danh sách TẤT CẢ xe trong kho Auto X. "
                "Gọi khi: hỏi danh sách xe, có xe gì, xe nào đang bán, "
                "xe rẻ/đắt nhất, bảng giá tổng quát."
            ),
            "parameters": {"type": "object", "properties": {}, "required": []},
        },
    },
    {
        "type": "function",
        "function": {
            "name": "get_car_detail",
            "description": (
                "Lấy chi tiết 1 xe: phiên bản, giá, màu, thông số, tính năng. "
                "Gọi khi hỏi về 1 xe cụ thể. Dùng db_name từ list_cars."
            ),
            "parameters": {
                "type": "object",
                "properties": {
                    "car_name": {
                        "type": "string",
                        "description": "Tên xe. VD: 'VinFast VF 5', 'Toyota Camry'",
                    }
                },
                "required": ["car_name"],
            },
        },
    },
    {
        "type": "function",
        "function": {
            "name": "compare_cars",
            "description": "So sánh 2 xe: thông số, giá, tính năng. Gọi khi: so sánh X và Y, X vs Y, nên mua X hay Y.",
            "parameters": {
                "type": "object",
                "properties": {
                    "car_name_1": {"type": "string", "description": "Xe thứ nhất"},
                    "car_name_2": {"type": "string", "description": "Xe thứ hai"},
                },
                "required": ["car_name_1", "car_name_2"],
            },
        },
    },
    {
        "type": "function",
        "function": {
            "name": "search_cars_by_budget",
            "description": (
                "Tìm xe theo ngân sách. Gọi khi khách đề cập tiền: dưới X tỷ, tầm X triệu, budget X. "
                "Quy đổi: 1 tỷ = 1000000000; 1 triệu = 1000000."
            ),
            "parameters": {
                "type": "object",
                "properties": {
                    "max_price": {"type": "number", "description": "Giá tối đa (VNĐ)"},
                    "min_price": {"type": "number", "description": "Giá tối thiểu (VNĐ), mặc định 0"},
                },
                "required": ["max_price"],
            },
        },
    },
]

# ─── Tool definitions — Gemini format ────────────────────────────────────────
GEMINI_TOOLS = [
    types.Tool(
        function_declarations=[
            types.FunctionDeclaration(
                name="list_cars",
                description=(
                    "Lấy danh sách TẤT CẢ xe trong kho Auto X. "
                    "Gọi khi: hỏi danh sách xe, có xe gì, xe nào đang bán, "
                    "xe rẻ/đắt nhất, bảng giá tổng quát."
                ),
                parameters=types.Schema(type=types.Type.OBJECT, properties={}),
            ),
            types.FunctionDeclaration(
                name="get_car_detail",
                description=(
                    "Lấy chi tiết 1 xe: phiên bản, giá, màu, thông số, tính năng. "
                    "Gọi khi hỏi về 1 xe cụ thể. Dùng db_name từ list_cars."
                ),
                parameters=types.Schema(
                    type=types.Type.OBJECT,
                    properties={
                        "car_name": types.Schema(
                            type=types.Type.STRING,
                            description="Tên xe. VD: 'VinFast VF 5', 'Toyota Camry'",
                        )
                    },
                    required=["car_name"],
                ),
            ),
            types.FunctionDeclaration(
                name="compare_cars",
                description="So sánh 2 xe: thông số, giá, tính năng. Gọi khi: so sánh X và Y, X vs Y, nên mua X hay Y.",
                parameters=types.Schema(
                    type=types.Type.OBJECT,
                    properties={
                        "car_name_1": types.Schema(type=types.Type.STRING, description="Xe thứ nhất"),
                        "car_name_2": types.Schema(type=types.Type.STRING, description="Xe thứ hai"),
                    },
                    required=["car_name_1", "car_name_2"],
                ),
            ),
            types.FunctionDeclaration(
                name="search_cars_by_budget",
                description=(
                    "Tìm xe theo ngân sách. Gọi khi khách đề cập tiền: dưới X tỷ, tầm X triệu, budget X. "
                    "Quy đổi: 1 tỷ = 1000000000; 1 triệu = 1000000."
                ),
                parameters=types.Schema(
                    type=types.Type.OBJECT,
                    properties={
                        "max_price": types.Schema(type=types.Type.NUMBER, description="Giá tối đa (VNĐ)"),
                        "min_price": types.Schema(type=types.Type.NUMBER, description="Giá tối thiểu (VNĐ), mặc định 0"),
                    },
                    required=["max_price"],
                ),
            ),
        ]
    )
]

GEMINI_SAFETY = [
    types.SafetySetting(category="HARM_CATEGORY_HARASSMENT",        threshold="BLOCK_NONE"),
    types.SafetySetting(category="HARM_CATEGORY_HATE_SPEECH",       threshold="BLOCK_NONE"),
    types.SafetySetting(category="HARM_CATEGORY_SEXUALLY_EXPLICIT", threshold="BLOCK_NONE"),
    types.SafetySetting(category="HARM_CATEGORY_DANGEROUS_CONTENT", threshold="BLOCK_NONE"),
]


# ─── JSON Decimal encoder ────────────────────────────────────────────────────
import decimal

class _DecimalEncoder(json.JSONEncoder):
    def default(self, obj):
        if isinstance(obj, decimal.Decimal):
            return int(obj)
        return super().default(obj)

def _json_dumps(obj) -> str:
    return json.dumps(obj, ensure_ascii=False, cls=_DecimalEncoder)

# ─── DB helpers ───────────────────────────────────────────────────────────────
def _normalize(text: str) -> str:
    return " ".join(text.lower().split())


def _match_car(db: Session, query: str) -> Optional[Car]:
    cars = db.query(Car).all()
    if not cars:
        return None
    q = _normalize(query)

    # 1. Khớp chính xác tên
    for car in cars:
        if _normalize(car.name) == q:
            return car

    # 2. Khớp theo model (vd: "gle" → model="GLE" → "Mercedes-Benz GLE")
    for car in cars:
        model = _normalize(getattr(car, "model", "") or "")
        if model and (model == q or model in q or q in model):
            return car

    # 3. Khớp substring tên
    candidates = []
    for car in cars:
        name_lower = _normalize(car.name)
        if q in name_lower or name_lower in q:
            candidates.append((len(name_lower), car))
    if candidates:
        candidates.sort(key=lambda x: x[0])
        return candidates[0][1]

    # 4. Token score
    q_tokens = [t for t in q.split() if len(t) >= 2]
    if not q_tokens:
        return None
    best, best_score = None, 0
    for car in cars:
        name_lower  = _normalize(car.name)
        model_lower = _normalize(getattr(car, "model", "") or "")
        score  = sum(1 for t in q_tokens if t in name_lower)
        score += sum(2 for t in q_tokens if model_lower and t in model_lower)
        if score > best_score:
            best_score, best = score, car
    return best if best_score > 0 else None


def _fmt_price(price) -> str:
    try:
        p = int(price)
    except (TypeError, ValueError):
        return "Liên hệ"
    if p == 0:
        return "Liên hệ"
    ty    = p // 1_000_000_000
    trieu = (p % 1_000_000_000) // 1_000_000
    if ty and trieu:
        return f"{ty} tỷ {trieu:,} triệu"
    if ty:
        return f"{ty} tỷ"
    return f"{trieu:,} triệu"


def _build_car_data(db: Session, car: Car) -> Dict:
    variants = db.query(CarVariant).filter_by(car_id=car.id).order_by(CarVariant.sort_order).all()
    colors   = db.query(CarColor).filter_by(car_id=car.id).order_by(CarColor.sort_order).all()
    specs    = db.query(CarSpec).filter_by(car_id=car.id).order_by(CarSpec.category_order, CarSpec.sort_order).all()
    features = db.query(CarFeature).filter_by(car_id=car.id).all()

    specs_grouped: Dict[str, List[str]] = {}
    for s in specs:
        specs_grouped.setdefault(s.category, []).append(f"{s.spec_key}: {s.spec_value}")

    if not specs_grouped:
        basic: Dict[str, str] = {}
        if getattr(car, "engine", None):       basic["Động cơ"]    = car.engine
        if getattr(car, "seats", None):        basic["Số chỗ"]     = str(car.seats)
        if getattr(car, "fuel_type", None):    basic["Nhiên liệu"] = car.fuel_type
        if getattr(car, "transmission", None): basic["Hộp số"]     = car.transmission
        if basic:
            specs_grouped["Thông số cơ bản"] = [f"{k}: {v}" for k, v in basic.items()]

    features_grouped: Dict[str, List[str]] = {}
    for f in features:
        cat  = getattr(f, "category", None) or getattr(f, "title", "Tính năng")
        desc = getattr(f, "description", "") or ""
        if desc:
            features_grouped.setdefault(cat, []).append(desc)

    color_names = [c.name for c in colors]
    if not color_names and getattr(car, "color", None):
        color_names = [car.color]

    prices = [v.price for v in variants if v.price]
    price_range = ""
    if prices:
        lo, hi = min(prices), max(prices)
        price_range = _fmt_price(lo) if lo == hi else f"{_fmt_price(lo)} – {_fmt_price(hi)}"

    return {
        "status":      "found",
        "db_name":     car.name,
        "price_range": price_range,
        "variants":    [{"name": v.name, "price": _fmt_price(v.price), "price_raw": int(v.price) if v.price else 0} for v in variants],
        "colors":      color_names or ["Liên hệ showroom"],
        "specs":       specs_grouped,
        "features":    features_grouped,
    }


# ─── Tool implementations ─────────────────────────────────────────────────────
def tool_list_cars() -> str:
    db: Session = SessionLocal()
    try:
        cars   = db.query(Car).all()
        result = []
        for car in cars:
            variants = db.query(CarVariant).filter_by(car_id=car.id).order_by(CarVariant.sort_order).all()
            prices   = [v.price for v in variants if v.price]
            entry: Dict = {"db_name": car.name, "price_from": _fmt_price(min(prices)) if prices else "Liên hệ"}
            if prices and max(prices) != min(prices):
                entry["price_to"] = _fmt_price(max(prices))
            if getattr(car, "fuel_type", None): entry["fuel_type"] = car.fuel_type
            if getattr(car, "seats", None):     entry["seats"]     = car.seats
            result.append(entry)
        logger.info(f"list_cars → {len(result)} cars")
        return json.dumps({"note": "TOÀN BỘ xe kho Auto X.", "total": len(result), "cars": result}, ensure_ascii=False)
    except Exception as e:
        logger.error(f"list_cars error: {e}")
        return json.dumps({"error": str(e)})
    finally:
        db.close()


def tool_get_car_detail(car_name: str) -> str:
    db: Session = SessionLocal()
    try:
        car = _match_car(db, car_name)
        if not car:
            return json.dumps({"status": "not_found", "car_name": car_name,
                               "note": "Không có trong kho. Dùng list_cars để gợi ý xe khác."}, ensure_ascii=False)
        data = _build_car_data(db, car)
        logger.info(f"get_car_detail({car_name!r}) → {car.name}")
        return _json_dumps(data)
    except Exception as e:
        logger.error(f"get_car_detail error: {e}")
        return json.dumps({"error": str(e)})
    finally:
        db.close()


def tool_compare_cars(car_name_1: str, car_name_2: str) -> str:
    db: Session = SessionLocal()
    try:
        car1 = _match_car(db, car_name_1)
        car2 = _match_car(db, car_name_2)
        result = {
            "car_1": _build_car_data(db, car1) if car1 else {"status": "not_found", "car_name": car_name_1},
            "car_2": _build_car_data(db, car2) if car2 else {"status": "not_found", "car_name": car_name_2},
        }
        logger.info(f"compare_cars: {car_name_1!r} vs {car_name_2!r}")
        return _json_dumps(result)
    except Exception as e:
        logger.error(f"compare_cars error: {e}")
        return json.dumps({"error": str(e)})
    finally:
        db.close()


def tool_search_by_budget(max_price: float, min_price: float = 0) -> str:
    db: Session = SessionLocal()
    try:
        variants = (
            db.query(CarVariant)
            .filter(CarVariant.price >= min_price, CarVariant.price <= max_price)
            .order_by(CarVariant.price).all()
        )
        result, seen = [], set()
        for v in variants:
            car = db.query(Car).filter_by(id=v.car_id).first()
            if car and car.id not in seen:
                seen.add(car.id)
                result.append({"db_name": car.name, "variant": v.name, "price": _fmt_price(v.price),
                                "fuel_type": getattr(car, "fuel_type", ""), "seats": getattr(car, "seats", "")})
        if not result:
            return json.dumps({"status": "not_found", "message": "Không có xe trong khoảng giá này.",
                               "note": "Gợi ý khách điều chỉnh ngân sách hoặc gọi list_cars."})
        logger.info(f"search_by_budget {min_price:,.0f}–{max_price:,.0f} → {len(result)} xe")
        return json.dumps({"status": "found", "count": len(result), "results": result}, ensure_ascii=False)
    except Exception as e:
        logger.error(f"search_by_budget error: {e}")
        return json.dumps({"error": str(e)})
    finally:
        db.close()


def _sanitize_tool_name(name: str) -> str:
    return name.split("{")[0].split("(")[0].strip()


def _dispatch_compare(car_name_1: str, car_name_2: str) -> str:
    """
    Wrapper cho compare_cars: nếu bất kỳ xe nào not_found,
    trả về instruction rõ ràng để model KHÔNG hỏi thêm.
    """
    raw    = tool_compare_cars(car_name_1, car_name_2)
    result = json.loads(raw)
    not_found = []
    if result.get("car_1", {}).get("status") == "not_found":
        not_found.append(result["car_1"].get("car_name", car_name_1))
    if result.get("car_2", {}).get("status") == "not_found":
        not_found.append(result["car_2"].get("car_name", car_name_2))
    if not_found:
        all_cars = json.loads(tool_list_cars()).get("cars", [])
        car_list = "\n".join(f"- {c['db_name']} — từ {c['price_from']}" for c in all_cars)
        missing_str = ", ".join(not_found)
        instruction = (
            f"KHÔNG CÓ {missing_str} TRONG KHO. "
            f"TUYỆT ĐỐI KHÔNG hỏi thêm, KHÔNG yêu cầu chọn mẫu cụ thể. "
            f"Trả lời ngay bằng đúng nội dung này: "
            f"'Showroom không có {missing_str} trong kho. Các xe hiện có:\n{car_list}'"
        )
        return json.dumps({"status": "not_found", "missing": not_found, "instruction": instruction}, ensure_ascii=False)
    return raw


def _dispatch_tool(name: str, args: Dict) -> str:
    name = _sanitize_tool_name(name)
    if name == "list_cars":             return tool_list_cars()
    if name == "get_car_detail":        return tool_get_car_detail(args.get("car_name", ""))
    if name == "compare_cars":          return _dispatch_compare(args.get("car_name_1", ""), args.get("car_name_2", ""))
    if name == "search_cars_by_budget": return tool_search_by_budget(float(args.get("max_price", 0)), float(args.get("min_price", 0)))
    return json.dumps({"error": f"Unknown tool: {name}"})


# ─── Color detection helper ───────────────────────────────────────────────────
_COLOR_MAP = {
    "Trắng": ["white", "polar", "trắng", "silver", "bạc", "light"],
    "Đen":   ["black", "obsidian", "đen", "dark"],
    "Xám":   ["gray", "grey", "selenite", "xám", "silver", "graphite"],
    "Xanh":  ["blue", "navy", "nautic", "xanh", "cyan", "azure"],
    "Đỏ":    ["red", "đỏ", "crimson", "ruby", "scarlet", "maroon"],
    "Vàng":  ["yellow", "vàng", "gold", "chanh"],
    "Nâu":   ["brown", "nâu", "bronze", "tan", "caramel"],
    "Hồng":  ["pink", "hồng", "pastel", "rose"],
    "Tím":   ["purple", "violet", "tím"],
    "Cam":   ["orange", "cam"],
}

def _detect_color_from_vision(description: str) -> Optional[str]:
    if not description:
        return None
    desc_lower = description.lower()
    for vi_color, keywords in _COLOR_MAP.items():
        if any(kw in desc_lower for kw in keywords):
            return vi_color
    return None

def _color_exists_in_db(detected_color_vi: str, db_colors: List[str]) -> bool:
    if not detected_color_vi or not db_colors:
        return False
    detected_lower = detected_color_vi.lower()
    for db_color in db_colors:
        if detected_lower in db_color.lower():
            return True
    return False

def _normalize_model_name(model: str) -> str:
    m = model.strip()
    m = m.replace("-", " ").replace("_", " ")
    m = re.sub(r'([a-zA-Z])(\d)', r'\1 \2', m)
    m = re.sub(r'(\d)([a-zA-Z])', r'\1 \2', m)
    m = re.sub(r'\s+', ' ', m)
    return m.strip()

def _make_keywords(make: str) -> List[str]:
    mk = make.lower().strip()
    if "vinfast" in mk:
        return ["vinfast"]
    if any(x in mk for x in ["mercedes", "benz", "amg", "maybach"]):
        return ["mercedes"]
    if "bmw" in mk:
        return ["bmw"]
    if "audi" in mk:
        return ["audi"]
    if "toyota" in mk:
        return ["toyota"]
    if "honda" in mk:
        return ["honda"]
    if "hyundai" in mk:
        return ["hyundai"]
    if "kia" in mk:
        return ["kia"]
    if "lexus" in mk:
        return ["lexus"]
    return [mk]

def _score_car_match(db_name: str, make: str, model_name: str) -> int:
    dn = db_name.lower()
    score = 0

    for kw in _make_keywords(make):
        if kw in dn:
            score += 10
            break

    mo_raw   = model_name.lower().strip()
    mo_norm  = _normalize_model_name(model_name).lower().strip()
    mo_plain = re.sub(r'[-_]', ' ', mo_raw).strip()
    mo_plain = re.sub(r'\s+', ' ', mo_plain)

    candidates = []
    for mo in [mo_raw, mo_norm, mo_plain]:
        if mo and mo not in candidates:
            candidates.append(mo)

    best_model_score = 0
    for mo in candidates:
        local_score = 0
        if mo in dn:
            local_score = 20
        else:
            tokens = [t for t in mo.split() if len(t) >= 1]
            if tokens:
                matched = sum(1 for t in tokens if t in dn)
                ratio   = matched / len(tokens)
                local_score = int(ratio * 15)
        if local_score > best_model_score:
            best_model_score = local_score
        if best_model_score >= 20:
            break

    score += best_model_score
    return score


# ─── Chatbot ──────────────────────────────────────────────────────────────────
class Chatbot:
    # Groq
    GROQ_MODEL       = "llama-3.3-70b-versatile"
    GROQ_FALLBACKS   = ["llama-3.1-8b-instant", "llama3-70b-8192", "mistral-small-2503"]
    VISION_MODEL     = "meta-llama/llama-4-scout-17b-16e-instruct"
    VISION_FALLBACKS = ["llava-v1.5-7b-4096-preview"]

    # Gemini (backup khi Groq hết quota)
    GEMINI_MODEL    = "gemini-2.0-flash-lite"
    GEMINI_FALLBACK = "gemini-2.0-flash"

    SHOWROOM        = "Auto X"
    MAX_HISTORY     = 10
    MAX_TOOL_ROUNDS = 4
    TEMPERATURE     = 0.4

    _MATCH_THRESHOLD = 12

    def __init__(self):
        logger.info(f"Initializing chatbot (Groq/{self.GROQ_MODEL} → Gemini/{self.GEMINI_MODEL})...")

        groq_key = os.getenv("GROQ_API_KEY")
        if not groq_key:
            raise ValueError("GROQ_API_KEY missing in .env")
        self.groq = Groq(api_key=groq_key)

        gemini_key = os.getenv("GEMINI_API_KEY")
        self.gemini: Optional[genai.Client] = None
        if gemini_key:
            self.gemini = genai.Client(api_key=gemini_key)
            logger.info("Gemini client ready (fallback).")
        else:
            logger.warning("GEMINI_API_KEY not set — Gemini fallback disabled.")

        self._raw_sessions: Dict = _load_all_sessions()
        self.conversations: Dict[str, Conversation] = {}
        for sid, data in self._raw_sessions.items():
            try:
                self.conversations[sid] = Conversation(**data)
            except Exception:
                pass
        logger.info(f"Chatbot ready. Loaded {len(self.conversations)} sessions.")

    # ── System prompt ─────────────────────────────────────────────────────
    def _system_prompt(self) -> str:
        return f"""Bạn là tư vấn viên xe showroom {self.SHOWROOM}. Chỉ tư vấn về xe ô tô. Nói chuyện tự nhiên, ngắn gọn.

PHẠM VI CHỦ ĐỀ — CHỈ trả lời các câu hỏi liên quan đến:
- Xe ô tô (mua xe, giá xe, thông số, so sánh, tư vấn chọn xe)
- Dịch vụ showroom (lái thử, bảo dưỡng, tư vấn mua xe)
- Tài chính mua xe (ngân sách, trả góp)

TỪ CHỐI TUYỆT ĐỐI — KHÔNG trả lời bất kỳ câu hỏi nào NGOÀI chủ đề xe, bao gồm:
- Kiến thức chung, lịch sử, khoa học, công nghệ, lập trình
- Tin tức, chính trị, thể thao, giải trí
- Nấu ăn, du lịch, sức khỏe, hay bất kỳ chủ đề nào khác
Khi gặp câu hỏi ngoài chủ đề, CHỈ trả lời đúng 1 câu: "Mình chỉ có thể tư vấn về xe ô tô, bạn có câu hỏi nào về xe không?"

TOOL — GỌI KHI NÀO:
- Hỏi danh sách / bảng giá chung → list_cars
- Hỏi chi tiết 1 xe → get_car_detail (dùng db_name từ list_cars)
- So sánh 2 xe → compare_cars
- Đề cập ngân sách / số tiền → search_cars_by_budget
- get_car_detail trả về not_found → gọi thêm list_cars để gợi ý

QUY TẮC:
- Giá, tên, thông số: lấy CHÍNH XÁC từ tool, không ước đoán.
- Xe không có trong tool → KHÔNG nhắc đến xe đó nữa. Chỉ gợi ý các xe CÓ trong kho.
- So sánh mà tool trả về not_found cho bất kỳ xe nào → DỪNG NGAY. KHÔNG hỏi thêm, KHÔNG yêu cầu chọn mẫu cụ thể. Chỉ nói "Showroom không có [tên xe]." rồi gọi list_cars và liệt kê danh sách xe có trong kho.
- Khách hỏi xe ngoài kho → KHÔNG tư vấn, KHÔNG bịa thông số. Chỉ nói không có và gợi ý xe tương tự trong kho.
- Câu hỏi chung về xe (không cần tool): trả lời tự nhiên theo kiến thức chung, không bịa thông số cụ thể.

VÍ DỤ XỬ LÝ SO SÁNH THẤT BẠI (làm đúng như thế này):
Khách: "So sánh VinFast VF 5 và BMW"
Tool compare_cars trả về: car_2 status=not_found
Trả lời ĐÚNG: "Showroom không có BMW trong kho. Các xe hiện có:\n- [danh sách từ list_cars]"
Trả lời SAI (tuyệt đối không làm): "Bạn cần chọn mẫu BMW cụ thể vì không có thông tin về BMW trong danh sách."

CÁCH VIẾT:
- Tối đa 150 từ mỗi câu trả lời.
- Gạch đầu dòng khi liệt kê. Không dùng emoji.
- Đặt lịch lái thử → gợi ý /services/dat-lich-bao-duong."""

    # ── Persist ───────────────────────────────────────────────────────────
    def _persist_session(self, session_id: str) -> None:
        conv = self.conversations.get(session_id)
        if not conv:
            return
        clean_msgs = [
            m for m in conv.messages[-_MAX_SESSION_MESSAGES:]
            if m.get("role") in ("user", "assistant") and m.get("content")
        ]
        self._raw_sessions[session_id] = {
            "messages":         clean_msgs,
            "last_interaction": conv.last_interaction,
        }
        _save_all_sessions(self._raw_sessions)

    # ── Groq call ─────────────────────────────────────────────────────────
    def _call_groq(self, messages: List[Dict], session_id: str, round_num: int = 0) -> Tuple[object, str]:
        for model in [self.GROQ_MODEL] + self.GROQ_FALLBACKS:
            try:
                response = self.groq.chat.completions.create(
                    model=model, messages=messages, tools=GROQ_TOOLS,
                    tool_choice="auto", max_tokens=800, temperature=self.TEMPERATURE,
                )
                if model != self.GROQ_MODEL:
                    logger.warning(f"[{session_id}] Round {round_num + 1}: Groq fallback → '{model}'")
                return response, model
            except (RateLimitError, BadRequestError) as e:
                logger.warning(f"[{session_id}] Groq skip '{model}': {e}")
                continue
        raise RateLimitError("All Groq models exhausted.")

    # ── Gemini call ───────────────────────────────────────────────────────
    def _call_gemini(self, history: List[types.Content], user_input: str, session_id: str) -> Tuple[object, object, str]:
        if not self.gemini:
            raise ResourceExhausted("Gemini client not configured.")
        config = types.GenerateContentConfig(
            system_instruction=self._system_prompt(),
            tools=GEMINI_TOOLS,
            safety_settings=GEMINI_SAFETY,
        )
        for model_name in [self.GEMINI_MODEL, self.GEMINI_FALLBACK]:
            try:
                chat     = self.gemini.chats.create(model=model_name, history=history, config=config)
                response = chat.send_message(user_input)
                if model_name != self.GEMINI_MODEL:
                    logger.warning(f"[{session_id}] Gemini fallback → '{model_name}'")
                logger.warning(f"[{session_id}] Using Gemini backup: '{model_name}'")
                return chat, response, model_name
            except ResourceExhausted as e:
                logger.warning(f"[{session_id}] Gemini skip '{model_name}': {e}")
                continue
            except Exception as e:
                logger.warning(f"[{session_id}] Gemini error '{model_name}': {e}")
                continue
        raise ResourceExhausted("All Gemini models exhausted.")

    # ── Vision: Groq ──────────────────────────────────────────────────────
    def _call_vision_groq(self, messages: List[Dict], session_id: str) -> Tuple[object, str]:
        for model in [self.VISION_MODEL] + self.VISION_FALLBACKS:
            try:
                response = self.groq.chat.completions.create(
                    model=model, messages=messages, max_tokens=300, temperature=0.1,
                )
                if model != self.VISION_MODEL:
                    logger.warning(f"[{session_id}] Vision Groq fallback → '{model}'")
                return response, model
            except (RateLimitError, BadRequestError) as e:
                logger.warning(f"[{session_id}] Vision Groq skip '{model}': {e}")
                continue
        raise RateLimitError("All Groq vision models exhausted.")

    # ── Vision: Gemini backup ─────────────────────────────────────────────
    def _call_vision_gemini(self, image_b64: str, media_type: str, session_id: str) -> Dict:
        if not self.gemini:
            raise ResourceExhausted("Gemini not configured.")
        import base64
        image_bytes = base64.b64decode(image_b64)
        prompt = (
            "Phân tích ảnh. Nếu là xe ô tô, trả về JSON (không markdown):\n"
            '{"make":"hãng","model":"model","year_estimate":"năm",'
            '"confidence":"high/medium/low","description":"1 câu tiếng Việt mô tả màu sắc và kiểu dáng"}\n'
            "Nếu không phải xe:\n"
            '{"make":null,"model":null,"year_estimate":null,'
            '"confidence":"low","description":"Không phải ảnh xe"}'
        )
        for model_name in [self.GEMINI_MODEL, self.GEMINI_FALLBACK]:
            try:
                response = self.gemini.models.generate_content(
                    model=model_name,
                    contents=[types.Content(parts=[
                        types.Part(inline_data=types.Blob(mime_type=media_type, data=image_bytes)),
                        types.Part(text=prompt),
                    ])],
                    config=types.GenerateContentConfig(safety_settings=GEMINI_SAFETY),
                )
                raw = response.text.strip()
                if raw.startswith("```"):
                    raw = "\n".join(raw.split("\n")[1:]).rstrip("`").strip()
                logger.warning(f"[{session_id}] Vision using Gemini backup: '{model_name}'")
                return json.loads(raw)
            except Exception as e:
                logger.warning(f"[{session_id}] Vision Gemini skip '{model_name}': {e}")
                continue
        raise ResourceExhausted("All vision models exhausted.")

    # ── Analyze image ─────────────────────────────────────────────────────
    def _analyze_image(self, image_b64: str, media_type: str, session_id: str = "default") -> Dict:
        vision_messages = [
            {
                "role": "user",
                "content": [
                    {"type": "image_url", "image_url": {"url": f"data:{media_type};base64,{image_b64}"}},
                    {
                        "type": "text",
                        "text": (
                            "Phân tích ảnh xe ô tô. Trả về JSON (không markdown, không giải thích):\n"
                            '{"make":"hãng xe (VD: Mercedes-Benz, VinFast, BMW, Audi)","model":"model đầy đủ (VD: GLE, VF 8, S-Class, E-Class, VF 6)","year_estimate":"năm ước tính hoặc null",'
                            '"confidence":"high/medium/low","description":"1 câu mô tả ngắn tiếng Việt bao gồm màu sắc và kiểu dáng xe"}\n'
                            "Nếu không phải xe ô tô:\n"
                            '{"make":null,"model":null,"year_estimate":null,'
                            '"confidence":"low","description":"Không phải ảnh xe"}'
                        ),
                    },
                ],
            }
        ]
        try:
            response, model_used = self._call_vision_groq(vision_messages, session_id)
            logger.info(f"[{session_id}] Vision model (Groq): {model_used}")
            raw = response.choices[0].message.content.strip()
            if raw.startswith("```"):
                raw = "\n".join(raw.split("\n")[1:]).rstrip("`").strip()
            return json.loads(raw)
        except Exception as e:
            logger.warning(f"[{session_id}] Groq vision failed, trying Gemini: {e}")

        try:
            return self._call_vision_gemini(image_b64, media_type, session_id)
        except Exception as e:
            logger.error(f"[{session_id}] All vision models failed: {e}")
            return {"make": None, "model": None, "year_estimate": None, "confidence": "low",
                    "description": "Hệ thống đang bận, vui lòng thử lại sau."}

    # ── Handle image ──────────────────────────────────────────────────────
    def handle_image(self, image_b64: str, media_type: str = "image/jpeg", session_id: str = "default") -> Dict:
        logger.info(f"[{session_id}] Image processing...")
        vision      = self._analyze_image(image_b64, media_type, session_id)
        make        = (vision.get("make") or "").strip()
        model_name  = (vision.get("model") or "").strip()
        year_est    = (vision.get("year_estimate") or "").strip()
        confidence  = vision.get("confidence", "low")
        description = vision.get("description", "")

        logger.info(f"[{session_id}] Vision: make={make!r}, model={model_name!r}, "
                    f"year={year_est!r}, confidence={confidence}, desc={description!r}")

        if not make or not model_name:
            reply = (
                "Không nhận diện được xe trong ảnh. "
                "Vui lòng gửi ảnh rõ hơn hoặc cho biết tên xe bạn muốn hỏi."
            )
            self._append_history(session_id, "[Ảnh — không nhận ra xe]", reply)
            return {"status": "success", "response": reply, "vision": vision, "car_detail": None}

        all_cars_raw = json.loads(tool_list_cars())
        all_cars     = all_cars_raw.get("cars", [])

        if not all_cars:
            reply = "Hiện tại hệ thống không thể truy xuất dữ liệu kho xe. Vui lòng thử lại sau."
            self._append_history(session_id, f"[Ảnh: {make} {model_name}]", reply)
            return {"status": "error", "response": reply, "vision": vision, "car_detail": None}

        scored = [
            (c["db_name"], _score_car_match(c["db_name"], make, model_name), c)
            for c in all_cars
        ]
        scored.sort(key=lambda x: x[1], reverse=True)
        best_name, best_score, best_car_entry = scored[0]

        logger.info(f"[{session_id}] Score detail — make={make!r} model={model_name!r}")
        for _n, _s, _ in scored[:5]:
            logger.info(f"[{session_id}]   {_n!r:40s} → {_s}đ")

        logger.info(f"[{session_id}] Top matches: {[(s[0], s[1]) for s in scored[:5]]}")

        if best_score < self._MATCH_THRESHOLD:
            suggest_lines = "\n".join(
                f"- {c['db_name']} — từ {c['price_from']}" for c in all_cars
            )
            reply = (
                f"Showroom không có mẫu {make} {model_name} trong kho.\n\n"
                f"Các xe đang có tại showroom:\n{suggest_lines}"
            )
            self._append_history(session_id, f"[Ảnh: {make} {model_name}]", reply)
            return {
                "status": "success", "response": reply,
                "vision": vision, "car_detail": {"status": "not_found"},
            }

        raw    = tool_get_car_detail(best_name)
        detail = json.loads(raw)

        if detail.get("status") != "found":
            suggest_lines = "\n".join(
                f"- {c['db_name']} — từ {c['price_from']}" for c in all_cars
            )
            reply = (
                f"Showroom không có mẫu {make} {model_name} trong kho.\n\n"
                f"Các xe đang có tại showroom:\n{suggest_lines}"
            )
            self._append_history(session_id, f"[Ảnh: {make} {model_name}]", reply)
            return {
                "status": "success", "response": reply,
                "vision": vision, "car_detail": {"status": "not_found"},
            }

        db_name  = detail["db_name"]
        variants = detail.get("variants", [])
        colors   = detail.get("colors", [])

        detected_color = _detect_color_from_vision(description)
        logger.info(f"[{session_id}] Detected color from vision: {detected_color!r}")
        logger.info(f"[{session_id}] Colors in DB: {colors}")

        color_in_stock = True
        if detected_color:
            color_in_stock = _color_exists_in_db(detected_color, colors)

        year_str = f" (khoảng {year_est})" if year_est else ""
        lines    = [f"Nhận diện: **{db_name}**{year_str}", ""]

        lines.append("**Phiên bản & Giá:**")
        for v in variants:
            lines.append(f"- {v['name']}: {v['price']}")

        lines.append("")

        if detected_color and not color_in_stock:
            colors_str = ", ".join(colors)
            lines.append(
                f"Màu **{detected_color}** trong ảnh hiện không có tại showroom. "
                f"Hiện tại chúng tôi chỉ có: {colors_str}."
            )
        else:
            colors_str = ", ".join(colors)
            lines.append(f"**Màu có sẵn:** {colors_str}")

        lines += ["", "Đặt lịch lái thử: /services/dat-lich"]

        reply = "\n".join(lines)
        self._append_history(session_id, f"[Ảnh: {make} {model_name}]", reply)
        return {
            "status":     "success",
            "response":   reply,
            "vision":     vision,
            "car_detail": detail,
        }

    # ── Text chat ─────────────────────────────────────────────────────────
    def get_response(self, user_input: str, session_id: str = "default") -> Dict:
        try:
            if session_id not in self.conversations:
                self.conversations[session_id] = Conversation()
            conv = self.conversations[session_id]
            conv.last_interaction = datetime.now().isoformat()

            tools_used: List[str] = []
            reply      = ""
            model_used = self.GROQ_MODEL

            groq_messages = [{"role": "system", "content": self._system_prompt()}]
            for m in conv.messages[-(self.MAX_HISTORY * 2):]:
                if m.get("role") in ("user", "assistant") and m.get("content"):
                    groq_messages.append({"role": m["role"], "content": m["content"]})
            groq_messages.append({"role": "user", "content": user_input})

            working_messages = list(groq_messages)
            groq_exhausted   = False

            for round_num in range(self.MAX_TOOL_ROUNDS):
                try:
                    response, model_used = self._call_groq(working_messages, session_id, round_num)
                except RateLimitError:
                    logger.warning(f"[{session_id}] All Groq models exhausted, switching to Gemini.")
                    groq_exhausted = True
                    break

                choice  = response.choices[0]
                message = choice.message

                if not message.tool_calls:
                    reply = (message.content or "").strip()
                    break

                working_messages.append({
                    "role": "assistant", "content": message.content or "",
                    "tool_calls": [
                        {"id": tc.id, "type": "function",
                         "function": {"name": tc.function.name, "arguments": tc.function.arguments}}
                        for tc in message.tool_calls
                    ],
                })

                for tc in message.tool_calls:
                    tool_name = _sanitize_tool_name(tc.function.name)
                    try:
                        tool_args = json.loads(tc.function.arguments)
                    except Exception:
                        tool_args = {}
                    tool_result = _dispatch_tool(tool_name, tool_args)
                    tools_used.append(tool_name)
                    logger.info(f"[{session_id}] Round {round_num + 1} [{model_used}] → {tool_name}({tool_args})")
                    working_messages.append({"role": "tool", "tool_call_id": tc.id, "content": tool_result})
            else:
                if not reply:
                    reply = "Xin lỗi, không thể xử lý yêu cầu. Vui lòng thử lại."

            if groq_exhausted:
                gemini_history = []
                for m in conv.messages[-(self.MAX_HISTORY * 2):]:
                    role    = m.get("role")
                    content = m.get("content", "")
                    if role == "user" and content:
                        gemini_history.append(types.Content(role="user", parts=[types.Part(text=content)]))
                    elif role == "assistant" and content:
                        gemini_history.append(types.Content(role="model", parts=[types.Part(text=content)]))

                try:
                    chat, g_response, model_used = self._call_gemini(gemini_history, user_input, session_id)

                    for round_num in range(self.MAX_TOOL_ROUNDS):
                        tool_calls = [
                            part.function_call
                            for part in g_response.candidates[0].content.parts
                            if part.function_call and part.function_call.name
                        ]
                        if not tool_calls:
                            try:
                                reply = g_response.text.strip()
                            except Exception:
                                reply = "Xin lỗi, không thể xử lý yêu cầu."
                            break

                        tool_result_parts = []
                        for fc in tool_calls:
                            tool_name   = fc.name
                            tool_args   = dict(fc.args)
                            tool_result = _dispatch_tool(tool_name, tool_args)
                            tools_used.append(tool_name)
                            logger.info(f"[{session_id}] Gemini Round {round_num + 1} [{model_used}] → {tool_name}({tool_args})")
                            tool_result_parts.append(
                                types.Part(function_response=types.FunctionResponse(
                                    name=tool_name, response={"result": tool_result}
                                ))
                            )
                        try:
                            g_response = chat.send_message(tool_result_parts)
                        except ResourceExhausted:
                            reply = "Xin lỗi, hệ thống đang quá tải. Vui lòng thử lại sau."
                            break
                    else:
                        if not reply:
                            reply = "Xin lỗi, không thể xử lý yêu cầu. Vui lòng thử lại."

                except ResourceExhausted:
                    reply      = "Xin lỗi, hệ thống đang quá tải. Vui lòng thử lại sau vài phút."
                    model_used = "none"

            if not reply:
                reply = "Xin lỗi, hệ thống không phản hồi được. Vui lòng thử lại."

            conv.messages.append({"role": "user",      "content": user_input})
            conv.messages.append({"role": "assistant", "content": reply})
            self._persist_session(session_id)

            logger.info(f"[{session_id}] Done. model={model_used} tools={tools_used}")
            return {"status": "success", "response": reply, "model_used": model_used, "tools_used": tools_used}

        except Exception as e:
            import traceback
            logger.error(f"[{session_id}] Error: {e}", exc_info=True)
            traceback.print_exc()
            return {"status": "error", "response": "Xin lỗi, có lỗi xảy ra. Vui lòng thử lại."}

    # ── Helpers ───────────────────────────────────────────────────────────
    def _append_history(self, session_id: str, user_msg: str, bot_msg: str) -> None:
        if session_id not in self.conversations:
            self.conversations[session_id] = Conversation()
        conv = self.conversations[session_id]
        conv.messages.append({"role": "user",      "content": user_msg})
        conv.messages.append({"role": "assistant", "content": bot_msg})
        conv.last_interaction = datetime.now().isoformat()
        self._persist_session(session_id)

    def clear_session(self, session_id: str) -> None:
        self.conversations.pop(session_id, None)
        self._raw_sessions.pop(session_id, None)
        _save_all_sessions(self._raw_sessions)
        logger.info(f"[{session_id}] Cleared.")

    def get_session_messages(self, session_id: str) -> List[Dict]:
        conv = self.conversations.get(session_id)
        if not conv:
            return []
        return [m for m in conv.messages if m.get("role") in ("user", "assistant")]

    def get_session_info(self, session_id: str) -> Dict:
        conv = self.conversations.get(session_id)
        if not conv:
            return {"exists": False}
        return {"exists": True, "message_count": len(conv.messages), "last_active": conv.last_interaction}


# ─── Singleton ────────────────────────────────────────────────────────────────
chatbot = Chatbot()


# ─── Public API ───────────────────────────────────────────────────────────────
def get_chatbot_response(user_input: str, session_id: str = "default") -> Dict:
    return chatbot.get_response(user_input, session_id)


def get_chatbot_image_response(image_b64: str, media_type: str = "image/jpeg", session_id: str = "default") -> Dict:
    return chatbot.handle_image(image_b64, media_type, session_id)


def get_car_detail_by_id(car_id: int) -> Optional[Dict]:
    db: Session = SessionLocal()
    try:
        car = db.query(Car).filter_by(id=car_id).first()
        if not car:
            return None
        data = _build_car_data(db, car)
        data["id"] = car_id
        return data if data.get("status") == "found" else None
    finally:
        db.close()


def get_session_messages(session_id: str = "default") -> List[Dict]:
    return chatbot.get_session_messages(session_id)


def clear_chatbot_session(session_id: str = "default") -> None:
    chatbot.clear_session(session_id)


def get_session_info(session_id: str = "default") -> Dict:
    return chatbot.get_session_info(session_id)


def debug_vision_score(make: str, model_name: str) -> Dict:
    all_cars = json.loads(tool_list_cars()).get("cars", [])
    scored = [
        {"db_name": c["db_name"], "score": _score_car_match(c["db_name"], make, model_name)}
        for c in all_cars
    ]
    scored.sort(key=lambda x: x["score"], reverse=True)
    return {
        "input": {"make": make, "model": model_name},
        "threshold": chatbot._MATCH_THRESHOLD,
        "best_match": scored[0] if scored else None,
        "found": scored[0]["score"] >= chatbot._MATCH_THRESHOLD if scored else False,
        "all_scores": scored,
    }