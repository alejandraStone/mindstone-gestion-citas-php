// validations.js -- Este módulo contiene funciones de validación para diferentes tipos de datos.

  // Solo letras y espacios, sin números ni caracteres extraños
export function isValidName(name) {
  return /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s'-]+$/.test(name);
}
  // Validación básica de email
export function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
  // Empieza con +, seguido de entre 6 y 15 dígitos
export function isValidInternationalPhone(phone) {
  return /^\+\d{6,15}$/.test(phone);
}
  // Mínimo 8 caracteres, al menos 1 mayúscula, 1 número y 1 carácter especial
export function isValidPassword(password) {
  return /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:'",.<>\/?\\|`~])[A-Za-z\d!@#$%^&*()_\-+=\[\]{};:'",.<>\/?\\|`~]{8,}$/.test(password);
}
