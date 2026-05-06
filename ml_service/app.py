from flask import Flask, request, jsonify
from sklearn.ensemble import RandomForestClassifier
import numpy as np
import json
import os
import joblib
from datetime import datetime

app = Flask(__name__)

# Model path
MODEL_PATH = 'models/risk_prediction_model.pkl'
SCALER_PATH = 'models/scaler.pkl'

# Initialize model and scaler
model = None
scaler = None

def load_model():
    """Load the trained ML model and scaler"""
    global model, scaler
    try:
        if os.path.exists(MODEL_PATH) and os.path.exists(SCALER_PATH):
            model = joblib.load(MODEL_PATH)
            scaler = joblib.load(SCALER_PATH)
            print("Model loaded successfully")
        else:
            print("Model files not found. Using untrained model.")
            model = RandomForestClassifier(n_estimators=100, random_state=42)
            scaler = None
    except Exception as e:
        print(f"Error loading model: {e}")

def train_model(X_train, y_train):
    """Train the risk prediction model"""
    global model, scaler
    from sklearn.preprocessing import StandardScaler
    
    scaler = StandardScaler()
    X_scaled = scaler.fit_transform(X_train)
    
    model = RandomForestClassifier(n_estimators=100, random_state=42)
    model.fit(X_scaled, y_train)
    
    # Save model and scaler
    os.makedirs('models', exist_ok=True)
    joblib.dump(model, MODEL_PATH)
    joblib.dump(scaler, SCALER_PATH)
    
    return model

@app.route('/', methods=['GET'])
def home():
    """API health and info endpoint"""
    return jsonify({
        "status": "running",
        "name": "EduInsight ML API",
        "version": "1.0",
        "endpoints": {
            "predict": "/predict-risk (POST)",
            "train": "/train-model (POST)",
            "stats": "/model-stats (GET)",
            "health": "/health (GET)"
        }
    }), 200

@app.route('/predict-risk', methods=['POST'])
def predict_risk():
    """
    Predict academic risk level for a student
    
    Expected JSON input:
    {
        "attendance_percentage": float,
        "internal_marks": float,
        "external_marks": float
    }
    
    Returns:
    {
        "risk_level": "Low Risk" | "Medium Risk" | "High Risk",
        "risk_score": float (0-1),
        "recommendations": [...]
    }
    """
    try:
        data = request.get_json()
        
        # Validate input
        required_fields = ['attendance_percentage', 'internal_marks', 'external_marks']
        if not all(field in data for field in required_fields):
            return jsonify({'error': 'Missing required fields'}), 400
        
        # Prepare features
        features = np.array([[
            data['attendance_percentage'],
            data['internal_marks'],
            data['external_marks']
        ]])
        
        # Scale features if scaler is available
        if scaler:
            features_scaled = scaler.transform(features)
        else:
            features_scaled = features
        
        # Make prediction
        if model:
            prediction = model.predict(features_scaled)[0]
            probabilities = model.predict_proba(features_scaled)[0]
            risk_score = np.max(probabilities)
        else:
            # Rule-based prediction if no model
            prediction = calculate_risk_rule_based(data)
            risk_score = calculate_risk_score(data)
        
        # Map prediction to risk level
        risk_levels = ['Low Risk', 'Medium Risk', 'High Risk']
        risk_level = risk_levels[prediction] if isinstance(prediction, (int, np.integer)) else prediction
        
        # Generate recommendations
        recommendations = generate_recommendations(data, risk_level)
        
        return jsonify({
            'risk_level': risk_level,
            'risk_score': float(risk_score),
            'recommendations': recommendations,
            'timestamp': datetime.now().isoformat()
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/train-model', methods=['POST'])
def train_new_model():
    """Train a new model with provided data"""
    try:
        data = request.get_json()
        
        X_train = np.array(data['X_train'])
        y_train = np.array(data['y_train'])
        
        train_model(X_train, y_train)
        
        return jsonify({
            'status': 'success',
            'message': 'Model trained and saved successfully'
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/model-stats', methods=['GET'])
def model_stats():
    """Get model statistics"""
    try:
        if model is None:
            return jsonify({'error': 'Model not loaded'}), 400
        
        return jsonify({
            'model_type': str(type(model).__name__),
            'n_estimators': model.n_estimators if hasattr(model, 'n_estimators') else None,
            'feature_importance': model.feature_importances_.tolist() if hasattr(model, 'feature_importances_') else None,
            'timestamp': datetime.now().isoformat()
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'model_loaded': model is not None,
        'timestamp': datetime.now().isoformat()
    })

def calculate_risk_rule_based(data):
    """Rule-based risk calculation when model is not available"""
    attendance = data.get('attendance_percentage', 100)
    internal = data.get('internal_marks', 0)
    external = data.get('external_marks', 0)
    
    total_marks = internal + external
    
    # Risk scoring logic
    risk_score = 0
    
    if attendance < 60:
        risk_score += 2
    elif attendance < 75:
        risk_score += 1
    
    if total_marks < 40:
        risk_score += 2
    elif total_marks < 50:
        risk_score += 1
    
    if risk_score >= 3:
        return 2  # High Risk
    elif risk_score >= 1:
        return 1  # Medium Risk
    else:
        return 0  # Low Risk

def calculate_risk_score(data):
    """Calculate numeric risk score (0-1)"""
    attendance = data.get('attendance_percentage', 100) / 100
    marks = (data.get('internal_marks', 0) + data.get('external_marks', 0)) / 100
    
    # Weighted average: attendance 40%, marks 60%
    risk_score = 1 - (0.4 * attendance + 0.6 * marks)
    return max(0, min(1, risk_score))

def generate_recommendations(data, risk_level):
    """Generate recommendations based on student data"""
    recommendations = []
    
    attendance = data.get('attendance_percentage', 100)
    marks = data.get('internal_marks', 0) + data.get('external_marks', 0)
    
    if attendance < 60:
        recommendations.append("Improve attendance urgently. Less than 60% attendance can lead to dismissal.")
    elif attendance < 75:
        recommendations.append("Increase class attendance. Aim for at least 75% attendance.")
    
    if marks < 40:
        recommendations.append("Seek immediate academic support. Current marks are below passing threshold.")
        recommendations.append("Consider enrolling in tutoring or forming study groups.")
    elif marks < 50:
        recommendations.append("Improve your marks. Current performance is just at passing level.")
    
    if risk_level == 'High Risk':
        recommendations.append("Schedule a meeting with your academic advisor immediately.")
        recommendations.append("Consider reducing course load or deferring non-essential courses.")
    
    if not recommendations:
        recommendations.append("Continue maintaining good performance.")
        recommendations.append("Focus on consistent attendance and higher marks.")
    
    return recommendations

if __name__ == '__main__':
    load_model()
    app.run(debug=True, port=5000, host='0.0.0.0')
