1. Tabla users (Laravel Default)
id
email
password

2. Tabla clientes (El Perfil)
Esta tabla extiende al usuario con sus datos personales.

id
user_id (Relación 1:1 con users)
nombre_completo
dni_personal
telefono
avatar

3. Tabla empresas (Los Negocios)
Aquí es donde aplicamos lo de "una o varias empresas".

id
cliente_id (Relación N:1 -> Varias empresas pertenecen a un mismo cliente)
razon_social (Nombre legal de la empresa)
ruc_nit (ID fiscal de la empresa)
direccion_fiscal

4. Tabla preguntas (El Banco de Datos)
id
orden (1, 2, 3... 40)
pregunta (El texto: "¿Cuenta con extintores vigentes?")
categoria (Seguridad, Finanzas, etc.)

5. Tabla auditorias (La Sesión)
id
empresa_id
titulo (Ej: "Auditoría Operativa 2024")
estado (Pendiente, En Proceso, Completada)
fecha_inicio
fecha_fin

6. Tabla respuestas (El Resultado + Evidencia)
id
auditoria_id
pregunta_id
respuesta (Texto o un boolean Si/No)
estado
archivo_evidencia (Ruta del archivo PDF/Imagen adjunto)
observaciones_auditor (Tus anotaciones sobre la respuesta)
fecha_inicio
fecha_fin

7. Tabla media (Polimórfica)
model_id, model_type (Para que pueda pertenecer a una Respuesta o a un Cliente).
file_path, file_name, mime_type.