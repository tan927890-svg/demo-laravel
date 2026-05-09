from sqlalchemy import Column, Integer, String, BigInteger, Boolean, Text, ForeignKey, Float
from sqlalchemy.orm import relationship
from database import Base
from pydantic import BaseModel


# ─── SQLAlchemy Models ────────────────────────────────────────────────────────

class Car(Base):
    __tablename__ = 'cars'

    id            = Column(Integer, primary_key=True, index=True)
    name          = Column(String(255))
    model         = Column(String(255), nullable=True)
    price_per_day = Column(BigInteger, nullable=True)   # giá chính
    color         = Column(String(255), nullable=True)
    fuel_type     = Column(String(100), nullable=True)
    engine        = Column(String(255), nullable=True)
    seats         = Column(Integer, nullable=True)
    condition     = Column(String(100), nullable=True)
    mileage       = Column(Integer, nullable=True)
    description   = Column(Text, nullable=True)
    status        = Column(String(100), nullable=True)
    is_featured   = Column(Boolean, default=False)
    badge_label   = Column(String(100), nullable=True)
    image_url     = Column(String(500), nullable=True)

    # Relationships (nếu có bảng phụ)
    variants = relationship('CarVariant', back_populates='car', cascade='all, delete-orphan')
    colors   = relationship('CarColor',   back_populates='car', cascade='all, delete-orphan')
    gallery  = relationship('CarGallery', back_populates='car', cascade='all, delete-orphan')
    specs    = relationship('CarSpec',    back_populates='car', cascade='all, delete-orphan')
    features = relationship('CarFeature', back_populates='car', cascade='all, delete-orphan')


class CarVariant(Base):
    __tablename__ = 'car_variants'

    id         = Column(Integer, primary_key=True, index=True)
    car_id     = Column(Integer, ForeignKey('cars.id'))
    name       = Column(String(255))
    price      = Column(BigInteger)
    sort_order = Column(Integer, default=0)

    car = relationship('Car', back_populates='variants')


class CarColor(Base):
    __tablename__ = 'car_colors'

    id          = Column(Integer, primary_key=True, index=True)
    car_id      = Column(Integer, ForeignKey('cars.id'))
    name        = Column(String(255))
    hex_code    = Column(String(20), nullable=True)
    image       = Column(String(500), nullable=True)
    is_default  = Column(Boolean, default=False)
    sort_order  = Column(Integer, default=0)
    price_addon = Column(BigInteger, default=0)

    car = relationship('Car', back_populates='colors')


class CarGallery(Base):
    __tablename__ = 'car_galleries'

    id         = Column(Integer, primary_key=True, index=True)
    car_id     = Column(Integer, ForeignKey('cars.id'))
    file_path  = Column(String(500))
    thumbnail  = Column(String(500), nullable=True)
    type       = Column(String(20), default='image')
    caption    = Column(String(500), nullable=True)
    sort_order = Column(Integer, default=0)

    car = relationship('Car', back_populates='gallery')


class CarSpec(Base):
    __tablename__ = 'car_specs'

    id             = Column(Integer, primary_key=True, index=True)
    car_id         = Column(Integer, ForeignKey('cars.id'))
    variant_id     = Column(Integer, ForeignKey('car_variants.id'), nullable=True)
    category       = Column(String(255))
    spec_key       = Column(String(255))
    spec_value     = Column(String(500))
    category_order = Column(Integer, default=0)
    sort_order     = Column(Integer, default=0)

    car = relationship('Car', back_populates='specs')


class CarFeature(Base):
    __tablename__ = 'car_features'

    id          = Column(Integer, primary_key=True, index=True)
    car_id      = Column(Integer, ForeignKey('cars.id'))
    variant_id  = Column(Integer, ForeignKey('car_variants.id'), nullable=True)
    title       = Column(String(255))
    description = Column(Text)
    image       = Column(String(500), nullable=True)
    sort_order  = Column(Integer, default=0)

    car = relationship('Car', back_populates='features')


# ─── Pydantic Schemas ─────────────────────────────────────────────────────────

class ChatInput(BaseModel):
    message: str
    session_id: str = "default"


class ImageInput(BaseModel):
    image_b64:  str
    media_type: str = "image/jpeg"
    session_id: str = "default"