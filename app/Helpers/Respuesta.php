<?php

namespace App\Helpers;

class Respuesta
{
    const titulo_exito_generico = 'Exito';
    const mensaje_exito_generico = 'Se pudo realizar la acción';
    //Creaciones correctas
    const mensaje_exito_generico_alimentos='El alimento se guardó con éxito';
    const mensaje_exito_generico_consulta='La consulta se guardó de manera correcta';
    const mensaje_exito_generico_expediente='El expediente se creó de correctamente';
    //Edición correcta
    const act_alimentos='El alimento se modificó correctamente';
    const act_consulta='La consulta se modificó correctamente';
    const act_expediente='El expediente se modificó correctamente';
    //Eliminación correcta
    const borrado_alimentos='El alimento fue eliminado';
    const baja_expediente='El expediente fue dado de baja de manera correcta';

    const titulo_error_generico = 'Error';
    const mensaje_error_generico = 'No se pudo realizar la accion, intente nuevamente';
    //Creaciones incorrectas
    const mensaje_error_alimentos='El alimento no se pudo guardar';
    const mensaje_error_consulta='La consulta no se pudo guardar';
    const mensaje_error_expediente='El expediente no se pudo crear';
    //Edición incorrecta
    const error_act_alimentos='El alimento no se pudo modificar';
    const error_act_consulta='La consulta no se pudo modificar';
    const error_act_expediente='El expediente no se pudo modificar';
    //Eliminación incorrecta
    const error_borrado_alimentos='El alimento no fue eliminado';
    const error_baja_expediente='El expediente no se pudo dar de baja';
    //Obtención incorrecta
    const error_obt_consulta='La consulta no pudo ser cargada';
}
