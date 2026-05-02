# Lógica de Negocio - AyfAuditor

Este documento define la estructura y reglas de negocio para el sistema **AyfAuditor**.

## 1. Identidad y Acceso
- **User**: Únicamente para Login (Email/Password).
- **Trabajador**: Perfil humano del staff de AyfAuditor (Interno).
  - Campos: `user_id`, `nombre`, `dni`, `especialidad`, `registro_profesional`.
  - *El Trabajador es el personal interno que puede tener roles como Admin, Auditor, etc.*
- **Cliente**: Perfil humano del dueño o representante (Externo).
  - Campos: `user_id`, `nombre`, `dni`, `celular`.
  - *El Cliente es la persona que contrata el servicio y gestiona sus empresas.*
- **Personal**: Perfil humano de trabajadores de la empresa auditada (Externo).
  - Campos: `user_id`, `nombre`, `dni`, `celular`.
  - *El Personal son los empleados invitados por el Cliente para ayudar en la auditoría.*

## 2. Estructura de Empresas
- **Empresa**: Entidad legal/fiscal a la cual se le realiza la auditoría.
  - **Relación**: Un Cliente (persona) puede registrar y gestionar múltiples Empresas (Relación 1:N).
  - Campos: `cliente_id` (FK), `razon_social`, `nombre_comercial`, `tax_id` (RUC/NIT/RFC - Único), `direccion_fiscal`.
- **PersonalEmpresa**: Relación entre trabajadores y la empresa.
  - Campos: `empresa_id` (FK), `user_id` (FK), `cargo`, `activo` (boolean).

## 3. Módulo de Auditoría (Colaborativo)
- **Pregunta**: Banco de preguntas maestras.
  - Campos: `orden`, `texto`, `categoria`, `descripcion_ayuda`.
- **Auditoria**: Sesión de inspección para una empresa y periodo específico.
  - Campos: `empresa_id` (FK), `titulo`, `estado` (Pendiente, En Proceso, Finalizada), `fecha_inicio`, `fecha_fin`.
- **ParticipanteAuditoria**: Usuarios vinculados a una sesión de auditoría.
  - **Tipos de Participantes**: 
    - **Admin**: Auditor/Gestor del sistema AyfAuditor.
    - **Empresario**: El Cliente principal dueño del negocio.
    - **Personal**: Trabajadores de la empresa del cliente invitados a colaborar.
  - Campos: `auditoria_id` (FK), `user_id` (FK), `rol` (ej: 'Dueño', 'Colaborador', 'Auditor'), `invitado_por` (FK - User).
- **Respuesta**: El espacio de colaboración.
  - Campos:
    - `auditoria_id` (FK), `pregunta_id` (FK).
    - `respuesta_cliente` (nullable).
    - `estado`: `vacio`, `enviado`, `en_revision`, `observado`, `aprobado`.
    - `fecha_inicio`, `fecha_fin`.

## 4. Sistema de Comunicación (Chat por Pregunta)
- **ComentarioRespuesta**: Permite discutir dudas sobre una pregunta específica.
  - Campos: `respuesta_id` (FK), `user_id` (FK), `mensaje` (text), `leido`.

## 5. Gestión de Archivos y Evidencias
- **Media (Polimorfismo)**: Vinculado a la tabla `respuestas`.
  - Campos: `file_path`, `file_name`, `mime_type`, `size`.

## 6. Trazabilidad e Historial (Logs)
- **ActivityLog**: Registro de auditoría interna del sistema.
  - **Propósito**: Saber quién cambió un estado, quién subió un archivo o quién modificó una respuesta.
  - Campos: `user_id`, `accion` (ej: "Aprobar Respuesta"), `modelo_afectado`, `valor_anterior`, `valor_nuevo`.
- **Historial de Auditoría**: Captura de fechas exactas de cambios de estado (Workflow timeline).

## 7. Reglas de Integridad y Flujo
- **SoftDeletes**: Activo en Clientes, Empresas y Auditorías para preservar evidencia histórica.
- **Unicidad**: El `tax_id` empresarial y el `dni_personal` son llaves únicas.
- **Entregables**: El sistema debe permitir generar un **PDF consolidado** con todas las respuestas y evidencias al finalizar.