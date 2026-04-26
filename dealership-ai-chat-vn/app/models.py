from sqlalchemy import Column, BigInteger, Integer, String, Numeric, Text, JSON
from app.database import Base
from pydantic import BaseModel
from typing import Optional

class Vehicle(Base):
    __tablename__ = 'cars'

    id = Column(BigInteger, primary_key=True, autoincrement=True)
    name = Column(String(255))
    tagline = Column(String(255))
    brand_id = Column(BigInteger)
    model = Column(String(255))
    price_per_day = Column(Numeric(15,0))
    cost_price = Column(Numeric(15,0))
    sale_price = Column(Numeric(15,0))
    badge_label = Column(String(60))
    seats = Column(Integer)
    description = Column(Text)
    status = Column(String(20))
    is_available = Column(Integer)

class ChatInput(BaseModel):
    message: str
    