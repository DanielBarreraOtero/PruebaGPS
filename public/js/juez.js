$(async function () {
    var respuesta = await $.ajax({
        type: "GET",
        url: "api/mensaje/all/" + indicativo,
        success: function (response) {
            if (response.ok) {
                return response;
            }
        }
    });

    var mensajes = respuesta.mensajes;

    console.table(mensajes);

    mensajes.forEach(mensaje => {
        mensaje.participante = mensaje.participante.indicativo;
        mensaje.banda = mensaje.banda.nombre;
        mensaje.modo = mensaje.modo.nombre;
        mensaje.hora = mensaje.hora.date;
    });

    $('#tablaMensajes').DataTable(
        {
            data: mensajes,
            columns: [
                { data: 'banda' },
                { data: 'modo' },
                { data: 'hora' },
                { data: 'participante' },
                { data: 'validado' }
            ]
        }
    );

    $('#tablaMensajes tr').click(function (ev) {
        console.log(ev);
    })

});