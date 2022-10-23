<?php

namespace App\Helpers;

class Respuesta
{
    const titulo_exito_generico = 'Exito';
    const mensaje_exito_generico = 'Se pudo realizar la acción';
    //Creaciones correctas
    const mensaje_exito_generico_alimentos='El alimento se guardó con éxito';
    const mensaje_exito_generico_consulta='La consulta se guardó de manera correcta';
    const mensaje_exito_generico_consulta_inicial='La consulta incial se guardó de manera correcta junto al expediente';
    const mensaje_exito_generico_expediente='El expediente se creó de correctamente';
    const mensaje_exito_generico_pliegues='Los datos de los pliegues se guardaron correctamente';
    //Edición correcta
    const act_alimentos='El alimento se modificó correctamente';
    const act_consulta='La consulta y dieta se actualizaron correctamente';
    const act_expediente='El expediente se modificó correctamente';
    const act_pliegues='Los pliegues se actualizaron correctamente';
    //Eliminación correcta
    const borrado_alimentos='El alimento fue eliminado';
    const baja_expediente='El expediente fue dado de baja de manera correcta';
    const alta_expediente='El expediente fue reactivado de manera correcta';

    const titulo_error_generico = 'Error';
    const mensaje_error_generico = 'No se pudo realizar la accion, intente nuevamente';
    //Creaciones incorrectas
    const mensaje_error_alimentos='El alimento no se pudo guardar';
    const mensaje_error_consulta='La consulta no se pudo guardar';
    const mensaje_error_expediente='El expediente no se pudo crear';
    const mensaje_error_pliegues='Los pliegues no se puedieron guardar';
    //Edición incorrecta
    const error_act_alimentos='El alimento no se pudo modificar';
    const error_act_consulta='La consulta no se pudo modificar';
    const error_act_expediente='El expediente no se pudo modificar';
    const error_act_pliegues='No se pudo actualizar los datos de pliegues';
    //Eliminación incorrecta
    const error_borrado_alimentos='El alimento no fue eliminado';
    const error_baja_expediente='El expediente no se pudo dar de baja';
    //Obtención incorrecta
    const error_obt_consulta='La consulta no pudo ser cargada';
    const error_obt_pliegues='No se pudo cargar los pliegues';

    //Citas
    const mensaje_exito_guardar_cita='La cita se guardó de manera correcta';
    const mensaje_error_guardar_cita='La cita no se pudo guardar';
    const mensaje_exito_actualizar_cita='La cita se actualizó de manera correcta';
    const mensaje_error_actualizar_cita='La cita no se pudo actualizar';
    const mensaje_exito_eliminar_cita='La cita se eliminó de manera correcta';
    const mensaje_error_eliminar_cita='La cita no se pudo eliminar';
    const mensaje_cita_horario_no_disponible='El horario seleccionado no está disponible';

    //Notificacion 
    const mensaje_exito_guardar_notificacion='La notificación por correo se envió de manera correcta';
    const mensaje_error_guardar_notificacion='La notificación por correo no se pudo enviar';
    const mensaje_paciente_no_enviar_notif='El paciente no tiene las notificaciones por correo activadas';
    const mensaje_no_correo_paciente='El paciente no tiene correo registrado';
}
