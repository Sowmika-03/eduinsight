# ML Service for EduInsight

This directory contains the Python Flask API for machine learning-based risk prediction.

## Setup

1. Install dependencies:
```bash
pip install -r requirements.txt
```

2. Train the model:
```bash
python train_model.py
```

3. Run the Flask API:
```bash
python app.py
```

The API will be running on `http://localhost:5000`

## Endpoints

### POST /predict-risk
Predict academic risk level for a student.

**Request:**
```json
{
    "attendance_percentage": 85,
    "internal_marks": 40,
    "external_marks": 35
}
```

**Response:**
```json
{
    "risk_level": "Low Risk",
    "risk_score": 0.15,
    "recommendations": [
        "Continue maintaining good performance."
    ]
}
```

### GET /health
Health check endpoint.

### GET /model-stats
Get model statistics and feature importances.

### POST /train-model
Train a new model with provided training data.

## Features Used

- **Attendance Percentage** (0-100)
- **Internal Marks** (0-50)
- **External Marks** (0-50)

## Risk Levels

- **Low Risk**: Score < 0.33
- **Medium Risk**: Score 0.33-0.66
- **High Risk**: Score > 0.66

## Model

The system uses a Random Forest Classifier trained on student academic data.
