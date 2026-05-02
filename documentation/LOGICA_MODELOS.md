php artisan make:model Cliente -mfsc
php artisan make:livewire erp.cliente.cliente-lista --class
php artisan make:livewire erp.cliente.cliente-crear --class
php artisan make:livewire erp.cliente.cliente-editar --class

php artisan make:model Empresa -mfsc
php artisan make:livewire erp.empresa.empresa-lista --class
php artisan make:livewire erp.empresa.empresa-crear --class
php artisan make:livewire erp.empresa.empresa-editar --class

php artisan make:model PersonalEmpresa -mfsc
php artisan make:livewire erp.personal-empresa.personal-empresa-lista --class
php artisan make:livewire erp.personal-empresa.personal-empresa-crear --class
php artisan make:livewire erp.personal-empresa.personal-empresa-editar --class

php artisan make:model Auditoria -mfsc
php artisan make:livewire erp.auditoria.auditoria-lista --class
php artisan make:livewire erp.auditoria.auditoria-crear --class
php artisan make:livewire erp.auditoria.auditoria-editar --class

php artisan make:model Pregunta -mfsc
php artisan make:livewire erp.pregunta.pregunta-lista --class
php artisan make:livewire erp.pregunta.pregunta-crear --class
php artisan make:livewire erp.pregunta.pregunta-editar --class

php artisan make:model Respuesta -mfsc
php artisan make:livewire erp.respuesta.respuesta-lista --class
php artisan make:livewire erp.respuesta.respuesta-crear --class
php artisan make:livewire erp.respuesta.respuesta-editar --class

php artisan make:model ParticipanteAuditoria -mfsc
php artisan make:livewire erp.participante-auditoria.participante-auditoria-lista --class
php artisan make:livewire erp.participante-auditoria.participante-auditoria-crear --class
php artisan make:livewire erp.participante-auditoria.participante-auditoria-editar --class

php artisan make:model ComentarioRespuesta -mfsc
php artisan make:livewire erp.comentario-respuesta.comentario-respuesta-lista --class
php artisan make:livewire erp.comentario-respuesta.comentario-respuesta-crear --class
php artisan make:livewire erp.comentario-respuesta.comentario-respuesta-editar --class

php artisan make:model Media -mfs
# Las evidencias multimedia usualmente se suben/muestran desde los componentes de Respuestas, no requieren un CRUD independiente.

php artisan make:model ActivityLog -mfsc
php artisan make:livewire erp.activity-log.activity-log-lista --class
# Los logs son de solo lectura, típicamente no llevan "crear" ni "editar" manual.

php artisan make:model AuditoriaHistorial -mfsc
php artisan make:livewire erp.auditoria-historial.auditoria-historial-lista --class
# El historial de cambios de estado suele visualizarse dentro del detalle de la Auditoría.