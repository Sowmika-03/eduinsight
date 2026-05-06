"""
Training script for the ML risk prediction model
Run this to train the model with your data
"""

from sklearn.ensemble import RandomForestClassifier
from sklearn.preprocessing import StandardScaler
import joblib
import numpy as np
import os

# Sample training data
# Features: [attendance_percentage, internal_marks, external_marks]
# Labels: 0 = Low Risk, 1 = Medium Risk, 2 = High Risk

X_train = np.array([
    [90, 45, 45],  # Low risk
    [85, 40, 40],  # Low risk
    [92, 48, 47],  # Low risk
    [88, 35, 35],  # Medium risk
    [75, 30, 30],  # Medium risk
    [80, 28, 28],  # Medium risk
    [55, 20, 15],  # High risk
    [50, 10, 10],  # High risk
    [45, 15, 20],  # High risk
    [72, 38, 38],  # Low risk
    [68, 30, 32],  # Medium risk
    [62, 25, 25],  # Medium risk
])

y_train = np.array([0, 0, 0, 1, 1, 1, 2, 2, 2, 0, 1, 1])

# Scale the features
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X_train)

# Train the model
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_scaled, y_train)

# Create models directory
os.makedirs('models', exist_ok=True)

# Save the model and scaler
joblib.dump(model, 'models/risk_prediction_model.pkl')
joblib.dump(scaler, 'models/scaler.pkl')

print("Model trained and saved successfully!")
print(f"Model accuracy on training data: {model.score(X_scaled, y_train):.2%}")
print(f"Feature importances: {model.feature_importances_}")
