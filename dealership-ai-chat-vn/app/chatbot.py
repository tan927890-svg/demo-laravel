from groq import Groq
import os
from typing import Dict, List
from datetime import datetime
import logging
import json
from pydantic import BaseModel, Field
from app.database import SessionLocal
from app.models import Vehicle

logger = logging.getLogger(__name__)
logger.setLevel(logging.INFO)
formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
file_handler = logging.FileHandler('chatbot.log')
file_handler.setFormatter(formatter)
stream_handler = logging.StreamHandler()
stream_handler.setFormatter(formatter)
logger.addHandler(file_handler)
logger.addHandler(stream_handler)
logger.propagate = False


class Conversation(BaseModel):
    messages: List[Dict[str, str]] = Field(default_factory=list)
    last_interaction: datetime = Field(default_factory=datetime.now)
    context: Dict = Field(default_factory=dict)


class Chatbot:
    def __init__(self):
        logger.info("Khởi tạo chatbot tư vấn ô tô...")
        self.client = self._initialize_groq_client()
        self.conversations: Dict[str, Conversation] = {}
        self.model = "llama-3.1-8b-instant"

    @staticmethod
    def _get_api_key() -> str:
        api_key = os.getenv('GROQ_API_KEY')
        if not api_key:
            raise ValueError("GROQ_API_KEY không tìm thấy trong biến môi trường")
        return api_key

    def _initialize_groq_client(self) -> Groq:
        try:
            client = Groq(api_key=self._get_api_key())
            logger.info("Groq client khởi tạo thành công")
            return client
        except Exception as e:
            logger.error(f"Lỗi khởi tạo Groq client: {e}")
            raise

    def _get_vehicles(self) -> str:
        db = SessionLocal()
        try:
            vehicles = db.query(Vehicle).filter(Vehicle.is_available == 1).all()
            logger.info(f"Lấy được {len(vehicles)} xe từ database")
            vehicle_details = [
                {
                    "ten_xe": v.name,
                    "dong_xe": v.model,
                    "so_cho": v.seats,
                    "gia_ban_vnd": float(v.sale_price) if v.sale_price else "Liên hệ để biết giá",
                }
                for v in vehicles
            ]
            return json.dumps(
                {"danh_sach_xe": vehicle_details, "tong_so_xe": len(vehicle_details)},
                indent=2, ensure_ascii=False, default=str
            )
        except Exception as e:
            logger.error(f"Lỗi cơ sở dữ liệu: {e}")
            raise
        finally:
            db.close()

    def _build_system_prompt(self, conversation: Conversation, inventory_json: str) -> str:
        return f"""Bạn là chuyên viên tư vấn BÁN XE của đại lý AUTO X tại Việt Nam. Đây là đại lý BÁN XE, KHÔNG cho thuê xe.

QUAN TRỌNG:
- TUYỆT ĐỐI không được đề cập đến "giá thuê", "cho thuê", "thuê xe", "giá thuê/tháng", "giá thuê/ngày" hay bất kỳ hình thức thuê xe nào.
- Chỉ có MỘT loại giá duy nhất là GIÁ BÁN (gia_ban_vnd).
- Nếu gia_ban_vnd là "Liên hệ để biết giá" thì trả lời đúng như vậy, không đoán mò.
- Chỉ tư vấn dựa trên dữ liệu kho xe được cung cấp.
- Luôn trả lời bằng tiếng Việt, thân thiện và chuyên nghiệp.
- Hiển thị giá theo định dạng: 2.310.000.000 VNĐ hoặc 2,31 tỷ VNĐ.
- Khi khách hỏi trả góp hoặc khuyến mãi, hướng họ liên hệ nhân viên kinh doanh.

Thông tin showroom AUTO X:
- Địa chỉ: Hẻm 2276/23 Trung Mỹ Tây, Quận 12, TP.HCM
- Hotline: 0909 123 456
- Email: info@autox.vn
- Giờ làm việc: T2-T7: 8:00-18:00 | CN: 9:00-17:00

Dữ liệu kho xe hiện tại:
{inventory_json}"""

    def get_response(self, user_input: str, session_id: str = "default") -> Dict:
        try:
            if session_id not in self.conversations:
                self.conversations[session_id] = Conversation()
            conversation = self.conversations[session_id]
            conversation.last_interaction = datetime.now()

            inventory = self._get_vehicles()
            system_prompt = self._build_system_prompt(conversation, inventory)
            conversation.messages.append({"role": "user", "content": user_input})

            response = self.client.chat.completions.create(
                model=self.model,
                messages=[
                    {"role": "system", "content": system_prompt},
                    *conversation.messages[-6:],
                ],
                temperature=0.5,
                max_tokens=600,
                top_p=1,
                stream=False,
            )

            response_content = response.choices[0].message.content
            conversation.messages.append({"role": "assistant", "content": response_content})
            return {"status": "success", "response": response_content}

        except Exception as e:
            logger.error(f"Lỗi tạo phản hồi: {e}")
            return {"status": "error", "response": str(e)}


chatbot = Chatbot()

def get_chatbot_response(user_input: str) -> Dict:
    return chatbot.get_response(user_input)