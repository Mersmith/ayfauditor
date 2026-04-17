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