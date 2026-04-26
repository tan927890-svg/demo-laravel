from fastapi import FastAPI, HTTPException, Depends, status
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy.orm import Session
from typing import List, Dict
from fastapi.responses import JSONResponse

from app.database import SessionLocal, engine
from app.models import Vehicle, Base, ChatInput
from app.chatbot import get_chatbot_response

Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="Đại Lý Ô Tô AI Chat",
    description="Chatbot tư vấn bán ô tô bằng tiếng Việt",
    version="1.0.0"
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

@app.get("/api", status_code=status.HTTP_200_OK)
async def root():
    return {"message": "Chào mừng đến với API Đại Lý Ô Tô"}

@app.get("/api/vehicles", status_code=status.HTTP_200_OK)
async def get_vehicles(db: Session = Depends(get_db)):
    vehicles = db.query(Vehicle).filter(Vehicle.is_available == 1).all()
    return vehicles

@app.post("/api/chat", response_model=Dict, status_code=status.HTTP_200_OK)
async def chat_endpoint(chat_input: ChatInput):
    try:
        response = get_chatbot_response(chat_input.message)
        if response["status"] == "error":
            raise HTTPException(
                status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
                detail=response["response"]
            )
        return response
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Chat service error: {str(e)}"
        )