"""
main.py — FastAPI wrapper cho chatbot.py
Chạy: uvicorn main:app --host 0.0.0.0 --port 8000 --reload
"""

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from typing import Optional
import logging
import json

from chatbot import get_chatbot_response, get_chatbot_image_response, clear_chatbot_session
from database import SessionLocal
from models import Car, CarVariant, CarColor, CarSpec, CarFeature

logger = logging.getLogger(__name__)

app = FastAPI(title="AutoViet Chatbot API", version="1.0.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["GET", "POST"],
    allow_headers=["*"],
)


# ── Schemas ───────────────────────────────────────────────────────────────────

class ChatRequest(BaseModel):
    message: str
    session_id: str = "default"

class ImageRequest(BaseModel):
    image_b64: str
    media_type: str = "image/jpeg"
    session_id: str = "default"

class ClearRequest(BaseModel):
    session_id: str = "default"


# ── Routes ────────────────────────────────────────────────────────────────────

@app.get("/health")
def health():
    return {"status": "ok"}


@app.get("/cars")
def get_all_cars():
    """
    Trả về toàn bộ dữ liệu xe từ DB để frontend lưu vào Local Storage.
    Gọi 1 lần khi load trang, không cần AI.
    """
    db = SessionLocal()
    try:
        cars = db.query(Car).all()
        result = []
        for car in cars:
            variants = (
                db.query(CarVariant).filter_by(car_id=car.id)
                .order_by(CarVariant.sort_order).all()
            )
            colors = (
                db.query(CarColor).filter_by(car_id=car.id)
                .order_by(CarColor.sort_order).all()
            )
            specs = (
                db.query(CarSpec).filter_by(car_id=car.id)
                .order_by(CarSpec.category_order, CarSpec.sort_order).all()
            )
            features = db.query(CarFeature).filter_by(car_id=car.id).all()

            # Specs grouped by category
            specs_grouped = {}
            for s in specs:
                specs_grouped.setdefault(s.category, []).append({
                    "key": s.spec_key,
                    "value": s.spec_value,
                })

            # Features grouped by category
            features_grouped = {}
            for f in features:
                cat = getattr(f, "category", "Tính năng")
                desc = getattr(f, "description", getattr(f, "name", ""))
                features_grouped.setdefault(cat, []).append(desc)

            result.append({
                "id":       car.id,
                "name":     car.name,
                "slug":     getattr(car, "slug", ""),
                "variants": [
                    {"name": v.name, "price": v.price}
                    for v in variants
                ],
                "min_price": variants[0].price if variants else 0,
                "max_price": variants[-1].price if variants else 0,
                "colors":   [c.name for c in colors],
                "specs":    specs_grouped,
                "features": features_grouped,
            })

        return {"status": "ok", "count": len(result), "cars": result}
    except Exception as e:
        logger.error(f"get_all_cars error: {e}")
        raise HTTPException(status_code=500, detail=str(e))
    finally:
        db.close()


@app.post("/chat")
def chat(body: ChatRequest):
    if not body.message.strip():
        raise HTTPException(status_code=400, detail="message không được để trống")
    result = get_chatbot_response(body.message, body.session_id)
    return result


@app.post("/chat/image")
def chat_image(body: ImageRequest):
    if not body.image_b64.strip():
        raise HTTPException(status_code=400, detail="image_b64 không được để trống")
    result = get_chatbot_image_response(body.image_b64, body.media_type, body.session_id)
    return result


@app.post("/chat/clear")
def clear_session(body: ClearRequest):
    clear_chatbot_session(body.session_id)
    return {"status": "ok", "message": f"Session '{body.session_id}' đã được xóa"}