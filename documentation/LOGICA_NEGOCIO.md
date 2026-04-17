# Lógica de Negocio - AyfAuditor

Este documento define la estructura y reglas de negocio para el sistema **AyfAuditor**.

## 1. Identidad y Acceso
- **User**: Únicamente para Login (Email/Password).
- **Cliente**: Perfil humano (Relación 1:1 con User).
  - Campos: `user_id`, `nombre`, `dni_personal`, `telefono`, `avatar`.
  - *El Cliente es el usuario que accede al portal para responder la auditoría.*

## 2. Estructura de Empresas
- **Empresa**: Entidad legal/fiscal.
  - Campos: `cliente_id` (FK), `razon_social`, `nombre_comercial`, `tax_id` (RUC/NIT/RFC - Único), `direccion_fiscal`.

## 3. Módulo de Auditoría (Colaborativo)
- **Pregunta**: Banco de preguntas maestras.
  - Campos: `orden`, `texto`, `categoria`, `descripcion_ayuda`.
- **Auditoria**: Sesión de inspección para una empresa y periodo específico.
  - Campos: `empresa_id` (FK), `titulo`, `estado` (Pendiente, En Proceso, Finalizada), `fecha_inicio`, `fecha_fin`.
- **Respuesta**: El espacio de colaboración.
  - Campos:
    - `auditoria_id` (FK), `pregunta_id` (FK).
    - `respuesta_cliente` (nullable).
    - `estado`: `vacio`, `enviado`, `en_revision`, `observado`, `aprobado`.
    - `fecha_inicio`, `fecha_fin`.

## 4. Sistema de Comunicación (Chat por Pregunta)
- **ComentarioRespuesta**: Permite discutir dudas sobre una pregunta específica.
  - Campos: 
    - `respuesta_id` (FK).
    - `user_id` (FK - Quién escribe).
    - `mensaje` (text).
    - `leido` (boolean).
  - *Notificación automática al usuario contrario al recibir un mensaje.*

## 5. Gestión de Archivos y Evidencias
- **Media (Polimorfismo)**: 
  - Vinculado a la tabla `respuestas`.
  - Campos: `file_path`, `file_name`, `mime_type`, `size`.

## 6. Reglas de Integridad y Flujo
- **SoftDeletes**: Activo en Clientes, Empresas y Auditorías.
- **Unicidad**: `tax_id` en Empresas y `dni_personal` en Clientes.
- **Flujo de Respuesta**:
  1. Auditor abre la Auditoría -> Se generan las 40 respuestas vacías.
  2. Cliente responde, sube media y puede preguntar vía chat de la respuesta.
  3. Auditor revisa, comenta y aprueba u observa.