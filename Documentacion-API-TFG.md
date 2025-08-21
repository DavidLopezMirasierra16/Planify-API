# Documentación API PLANIFY

## 0.- Autentificación del usuario
### *EXPLICACIÓN*
#### Para poder realizar algunas de las acciones de la API se necesitará un token para poder realizar dichas actividades.
#### ***Cabe recordar que se necesita tener el XAMPP instalado y en funcionamiento, así como ejecutar este archivo en la consola: php artisan serve y que la BASE DE DATOS se llame planify***

### *FUNCIONAMIENTO*
### - RegistroAPI
- Ruta: **/api/v1/registro**
- Método: **POST**
- Parámetros: **Un JSON con los datos requeridos para registrarse:**
    ```json
    {
        "nombre": "required|string|max:255",
        "apellidos": "required|string|max:255",
        "telefono": "required|string|max:15|unique:users,phone_number",
        "correo": "required|email|unique:users,email",
        "contrasenia": "required|string|min:6"
    }
    ```
- Acceso: **Admin/Cliente**
- Respuesta: **Nos registra el usuario en la BD.**
### - Login
- Ruta: **/api/v1/login**
- Método: **POST**
- Parámetros: **Un JSON con los datos del usuario:**
    ```json
    {
        "email": "required|string|email",
        "password": "required|string"
    }
    ```
- Respuesta: **Nos devuelve un token asignado a ese usuario**   
### Aquellas rutas que están protegidas para que solo se puedan utilizar si estás registrado y logueado, el token se tiene que poner en el ***Auth o Autentificación de la petición (Bearer Token)***. Si es necesario el token de autenticación se especificará en la documentación. Existen diversas rutas a las que solo los administradores tienen acceso.
### - User
- Ruta: **/api/v1/perfil**
- Método: **GET**
- Parámetros: **Ninguno**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve los datos del usuario.**
### - CambiarContraseña
- Ruta: **/api/v1/recuperarContraseña/{email}**
- Método: **PUT**
- Parámetros: **Un JSON con la nueva contraseña**
    ```json
    {
        "password": "required|string"
    }
    ```
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve la confirmación del cambio.**
### - Logout
- Ruta: **/api/v1/logout**
- Método: **POST**
- Parámetros: **Ninguno**
- Respuesta: **Nos elimina el token (nos cierra la sesion).**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 1.- Actividades
### *CRUD*
### - obtenerActividades
- Ruta: **api/v1/actividades**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todas las actividades registradas en la base de datos.**
### - crearActividad
- Ruta: **api/v1/actividades**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
        "nombre_actividad": "required|max:45",
        "enlace_actividad": "required|max:150|url",
        "descripcion": "required|max:45",
        "direccion_actividad": "required|max:45",
        "precio": "required|numeric",
        "viaje_id": "required|numeric"
    }
    ```
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea una actividad.**
### - editarActividad
- Ruta: **api/v1/actividades/{id}**
- Método: **PUT**
- Parámetros: **ID de la actividad que queremos editar y un JSON con los datos (como en crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita la actividad.**
### - eliminarActividad
- Ruta: **api/v1/actividades/{id}**
- Método: **DELETE**
- Parámetros: **ID de la actividad que eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina la actividad.**
### *CONSULTAS*
### - actividadId
- Ruta: **api/v1/actividades/id/{id}**
- Método: **GET**
- Parámetros: **ID de la actividad que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos de la actividad.**
### - actividadNombre
- Ruta: **api/v1/actividades/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre de la actividad que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos de la actividad.**
### - actividadDescripcion
- Ruta: **api/v1/actividades/descripcion/{descripcion}**
- Método: **GET**
- Parámetros: **Descripcion de la actividad que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos de la actividad.**
### - actividadDireccion
- Ruta: **api/v1/actividades/direccion/{direccion}**
- Método: **GET**
- Parámetros: **Direccion de la actividad que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos de la actividad.**
### - actividadPrecio
- Ruta: **api/v1/actividades/precio/{precio}**
- Método: **GET**
- Parámetros: **Precio de la actividad que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos de la actividad.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 2.- Destino vuelos
### *CRUD*
### - obtenerDestinos
- Ruta: **api/v1/destinoVuelo**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los vuelos de destinos registradas en la base de datos.**
### - crearDestino
- Ruta: **api/v1/destinoVuelo**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar**
    ```json
    {
        "destino_fk": "required|numeric",
        "terminal_salida": "required|string",
        "terminal_llegada": "required|string",
        "salida_fecha": "required|string",
        "llegada_fecha": "required|string",
        "vuelo_nombre": "required|string",
        "coste": "required|numeric"
    }
    ```
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea el viaje de vuelta y lo develve, con su ID (el que utilizaremos en la tabla de vuelos para insertar).**
### - editarDestino
- Ruta: **api/v1/destinoVuelo/{id}**
- Método: **PUT**
- Parámetros: **Id del viaje de vuelta que queremos editar y un JSON con los datos que queremos editar (como en crear)**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el vuelo de vuelta.**
### - eliminarDestino
- Ruta: **api/v1/destinoVuelo/{id}**
- Método: **DELETE**
- Parámetros: **Id del vuelo que queremos eliminar**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina el vuelo.**
### *CONSULTAS*
### - vueloId
- Ruta: **api/v1/destinoVuelo/id/{id}**
- Método: **GET**
- Parámetros: **Id del viaje de vuelta que queremos consultar**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos del vuelo de vuelta que coincide con el ID.**
### - vuelosalida
- Ruta: **api/v1/destinoVuelo/ida/{salida}**
- Método: **GET**
- Parámetros: **Fecha de ida del vuelo**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos del vuelo de vuelta que coincide con la fecha de ida.**
### - vueloLlegada
- Ruta: **api/v1/destinoVuelo/vuelta/{llegada}**
- Método: **GET**
- Parámetros: **Fecha de vuelta del vuelo**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos del vuelo de vuelta que coincide con la fecha de vuelta.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 3.- Destinos
### *CRUD*
**No hay CRUD para destinos ya que tenemos las 5 ciudades ya almacenadas.**
### *CONSULTAS*
### - obtenerDestinos
- Ruta: **api/v1/destinos**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos los destinos.**
### - destinoId
- Ruta: **api/v1/destinos/id/{id}**
- Método: **GET**
- Parámetros: **ID del destino que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el destino que coincide con el ID.**
### - destinoNombre
- Ruta: **api/v1/destinos/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del destino que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el destino que coincide con el nombre.**
### *IMAGENES*
**Las imagenes se encuentran en public/storage/imagenes, el JSON te devuelve en el campo de la imagen:**
```json
    {
        "imagen_destino": "imagenes/lisboa.jpg"
    }
```
**Para poder usar la foto tendras que crear la url: http://localhost:8000/storage/imagenes/lisboa.jpg o 'http://127.0.0.1:8000/storage/'+data.destino.imagen_destino**

```javascript
fetch('http://127.0.0.1:8000/api/v1/destinos/id/1')
    .then((response) => {
      return response.json();
    }).then((data) => {
      console.log(data);
      let link = 'http://127.0.0.1:8000/storage/'+data.destino.imagen_destino;
      let imagen = `<img src="${link}"></img>`;
      mostrar.innerHTML= imagen;
    }).catch((error) => {
      console.error(error);
    })
```

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 4.- Gastos
### *CRUD*
### - obtenerGastos
- Ruta: **api/v1/gastos**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los gastos.**
### - crearGasto
- Ruta: **api/v1/gastos**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
        "valor": "required|numeric",
        "integrante_fk": "required|numeric",
        "pagado": "required|numeric|min:0|max:1", //Booleano
        "descripcion": "Se permite null",
        "viaje_id": "required|numeric"
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea un gasto.**
### - editarGasto
- Ruta: **api/v1/gastos/{id}**
- Método: **PUT**
- Parámetros: **ID del gasto que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita un gasto.**
### - eliminarGasto
- Ruta: **api/v1/gastos/{id}**
- Método: **DELETE**
- Parámetros: **ID del gasto que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina un gasto.**
### *CONSULTAS*
### - gastoId
- Ruta: **api/v1/gastos/id/{id}**
- Método: **GET**
- Parámetros: **ID del gasto que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el gasto que coincide con el ID.**
### - gastoValor
- Ruta: **api/v1/gastos/valor/{valor}**
- Método: **GET**
- Parámetros: **Valor del gasto que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el gasto que coincide con el valor.**
### - gastoIntegrante
- Ruta: **api/v1/gastos/integrante/{integrante}**
- Método: **GET**
- Parámetros: **Integrante del gasto que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el gasto que coincide con el integrante.**
### - gastoPagado
- Ruta: **api/v1/gastos/pagado/{numero}**
- Método: **GET**
- Parámetros: **Estado del gasto que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el gasto que coincide con el numero (1 o 0).**
### - gastoDescripcion
- Ruta: **api/v1/gastos/descripcion/{descripcion}**
- Método: **GET**
- Parámetros: **Descripción del gasto que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el gasto que coincide con la descripcion.**
### - gastoUser
- Ruta: **api/v1/gastos/usuario/{id}**
- Método: **GET**
- Parámetros: **ID del usuario del cual queremos consultar sus gastos**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos sus gastos.**
### - gastoViaje
- Ruta: **api/v1/gastos/viaje/{viaje}**
- Método: **GET**
- Parámetros: **ID del viaje del cual queremos consultar sus gastos**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos sus gastos.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 5.- Hoteles
### *CRUD*
### - obtenerHoteles
- Ruta: **api/v1/hoteles**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los hoteles.**
### - crearHotel
- Ruta: **api/v1/hoteles**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
    "nombre": "required",
    "info":, //Puede ser null
    "rating": "required|numeric",
    "proveedor": "required",
    "precio": "required|numeric",
    "url": "required"
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea un hotel con su ID (del hotel creado).**
### - editarHotel
- Ruta: **api/v1/hoteles/{id}**
- Método: **PUT**
- Parámetros: **ID del hotel que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos edita el hotel que coincide con el ID.**
### - eliminarHotel
- Ruta: **api/v1/hoteles/{id}**
- Método: **DELETE**
- Parámetros: **ID del hotel que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina el hotel que coincide con el ID.**
### *CONSULTAS*
### - hotelId
- Ruta: **api/v1/hoteles/{id}**
- Método: **GET**
- Parámetros: **ID del hotel que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el hotel que coincide con el ID.**
### - hotelNombre
- Ruta: **api/v1/hoteles/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del hotel que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el hotel que coincide con el nombre.**
### - hotelInfo
- Ruta: **api/v1/hoteles/info/{info}**
- Método: **GET**
- Parámetros: **Informacion del hotel que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el hotel que coincide con la información.**
### - hotelRating
- Ruta: **api/v1/hoteles/rating/{rating}**
- Método: **GET**
- Parámetros: **Rating del hotel que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el hotel que coincide con el rating.**
### - hotelProveedor
- Ruta: **api/v1/hoteles/proveedor/{proveedor}**
- Método: **GET**
- Parámetros: **Proveedor del hotel que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el hotel que coincide con el proveedor.**
### - hotelPrecio
- Ruta: **api/v1/hoteles/precio/{precio}**
- Método: **GET**
- Parámetros: **Precio del hotel que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el hotel que coincide con el precio.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 6.- Idiomas
### *CRUD*
**No hay CRUD para idiomas ya que tenemos los 2 idiomas (Español, Ingles) ya almacenados.**
### *CONSULTAS*
### - obtenerIdiomas
- Ruta: **api/v1/idiomas**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos los idiomas.**
### - idiomaId
- Ruta: **api/v1/idiomas/{id}**
- Método: **GET**
- Parámetros: **ID del idioma que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el idioma que coincide con el ID.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 7.- Integrantes
### *CRUD*
### - obtenerIntegrantes
- Ruta: **api/v1/integrantes**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los integrantes.**
### - crearIntegrante
- Ruta: **api/v1/integrantes**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
        "viaje_fk": "required|numeric",
        "nombre": "required|string",
        "apellidos": "required|string",
        "edad": "required|numeric"
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea un intgrante.**
### - editarIntegrante
- Ruta: **api/v1/integrantes/{id}**
- Método: **PUT**
- Parámetros: **ID del integrante que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el integrante que coincide con el ID.**
### - eliminarIntegrante
- Ruta: **api/v1/integrantes/{id}**
- Método: **DELETE**
- Parámetros: **ID del integrante que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina el integrante que coincide con el ID.**
### - eliminarIntegranteUsuario
- Ruta: **api/v1/integrantes/eliminar/{usuario}**
- Método: **DELETE**
- Parámetros: **ID del integrante que queremos eliminar (comprueba que el creador del viaje sea el que elimina el integrante, a su vez comprueba que el integrante esté en ese viaje registrado).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos elimina el integrante que coincide con el ID.**
### *CONSULTAS*
### - integranteId
- Ruta: **api/v1/integrantes/id/{id}**
- Método: **GET**
- Parámetros: **ID del integrante que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el integrante que coincide con el ID.**
### - integranteNombre
- Ruta: **api/v1/integrantes/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del integrante que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el integrante que coincide con el nombre.**
### - integranteApellidos
- Ruta: **api/v1/integrantes/apellidos/{apellidos}**
- Método: **GET**
- Parámetros: **Apellido/s del integrante que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el integrante que coincide con el/los apellidos.**
### - integranteEdad
- Ruta: **api/v1/integrantes/edad/{edad}**
- Método: **GET**
- Parámetros: **Edad del integrante que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el integrante que coincide con la edad.**
### - integrantesViaje
- Ruta: **api/v1/integrantes/viaje/{id}**
- Método: **GET**
- Parámetros: **ID del viaje del que queremos consultar sus integrantes.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos los integrantes de ese viaje.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 8.- Itinerarios
### *CRUD*
### - obtenerItinerarios
- Ruta: **api/v1/itinerarios**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los itinerarios.**
### - crearItinerario
- Ruta: **api/v1/itinerarios**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
        "id_viaje_fk": "required|numeric",
        "nombre": "required|string",
        "descripcion": "required|string",
        "fecha_hora": "required",
        "ubicacion": "required|string"
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea un itinerario.**
### - editarItinerario
- Ruta: **api/v1/itinerarios/{id}**
- Método: **PUT**
- Parámetros: **ID del itinerario que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el itinerario que coincide con el ID.**
### - eliminarItinerario
- Ruta: **api/v1/itinerarios/{id}**
- Método: **DELETE**
- Parámetros: **ID del itinerario que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos elimina el itinerario que coincide con el ID.**
### *CONSULTAS*
### - itinerarioId
- Ruta: **api/v1/itinerarios/id/{id}**
- Método: **GET**
- Parámetros: **ID del itinerario que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el itinerario que coincide con el ID.**
### - itinerarioViaje
- Ruta: **api/v1/itinerarios/viaje/{id}**
- Método: **GET**
- Parámetros: **ID del viaje del cual queremos consultar sus itinerarios.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el itinerario que está asignado al viaje mediante el ID del viaje.**
### - itinerarioNombre
- Ruta: **api/v1/itinerarios/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del itinerario que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el itinerario que coincide con el nombre.**
### - itinerarioDescripcion
- Ruta: **api/v1/itinerarios/descripcion/{descripcion}**
- Método: **GET**
- Parámetros: **Descripcion del itinerario que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el itinerario que coincide con la descripcion.**
### - itinerarioFecha
- Ruta: **api/v1/itinerarios/fecha/{fecha}**
- Método: **GET**
- Parámetros: **Fecha del itinerario que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el itinerario que coincide con la fecha.**
### - itinerarioUbicacion
- Ruta: **api/v1/itinerarios/ubicacion/{ubicacion}**
- Método: **GET**
- Parámetros: **Ubicacion del itinerario que consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el itinerario que coincide con la ubicacion.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 9.- Monedas
### *CRUD*
**No hay CRUD para monedas ya que tenemos los 2 idiomas (euro, libra) ya almacenadas.**
### *CONSULTAS*
### - obtenerMonedas
- Ruta: **api/v1/monedas**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todas las monedas.**
### - monedasId
- Ruta: **api/v1/monedas/id/{id}**
- Método: **GET**
- Parámetros: **ID de la moneda que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve la moneda que coincide con el ID.**
### - monedasNombre
- Ruta: **api/v1/monedas/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre de la moneda que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve la moneda que coincide con el nombre.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 10.- OrigenVuelo
### *CRUD*
### - obtenerDestinos
- Ruta: **api/v1/origenVuelo**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los vuelos de origen registradas en la base de datos.**
### - crearOrigen
- Ruta: **api/v1/origenVuelo**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar**
    ```json
    {
        "origen_fk": "required|numeric",
        "terminal_salida": "required|string",
        "terminal_llegada": "required|string",
        "salida_fecha": "required|string",
        "llegada_fecha": "required|string",
        "vuelo_nombre": "required|string",
        "coste": "required|numeric"
    }
    ```
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea el vuelo y lo devuelve, con su ID (el que utilizaremos en la tabla de vuelos para insertar).**
### - editarOrigen
- Ruta: **api/v1/origenVuelo/{id}**
- Método: **PUT**
- Parámetros: **Id del vuelo de vuelta que queremos editar y un JSON con los datos que queremos editar (como en crear)**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el vuelo de vuelta.**
### - eliminarOrigen
- Ruta: **api/v1/origenVuelo/{id}**
- Método: **DELETE**
- Parámetros: **Id del vuelo que queremos eliminar**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina el vuelo.**
### *CONSULTAS*
### - vueloId
- Ruta: **api/v1/origenVuelo/id/{id}**
- Método: **GET**
- Parámetros: **Id del vuelo de vuelta que queremos consultar**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos del vuelo de vuelta que coincide con el ID.**
### - vuelosalida
- Ruta: **api/v1/origenVuelo/ida/{salida}**
- Método: **GET**
- Parámetros: **Fecha de ida del vuelo**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos del vuelo de vuelta que coincide con la fecha de ida.**
### - vueloLlegada
- Ruta: **api/v1/origenVuelo/vuelta/{llegada}**
- Método: **GET**
- Parámetros: **Fecha de vuelta del vuelo**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los datos del vuelo de vuelta que coincide con la fecha de vuelta.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 11.- Origenes
### *CRUD*
**No hay CRUD para origenes ya que tenemos las 5 ciudades ya almacenadas.**
### *CONSULTAS*
### - obtenerOrigenes
- Ruta: **api/v1/origenes**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos los origenes.**
### - origenesId
- Ruta: **api/v1/origenes/id/{id}**
- Método: **GET**
- Parámetros: **ID del origen que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el origen que coincide con el ID.**
### - origenesNombre
- Ruta: **api/v1/origenes/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del origen que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el origen que coincide con el nombre.**
### *IMAGENES*
**Las imagenes se encuentran en public/storage/imagenes, el JSON te devuelve en el campo de la imagen:**
```json
    {
        "imagen_origen": "imagenes/lisboa.jpg"
    }
```
**Para poder usar la foto tendras que crear la url: http://localhost:8000/storage/imagenes/lisboa.jpg o 'http://127.0.0.1:8000/storage/'+data.destino.imagen_origen**

```javascript
fetch('http://127.0.0.1:8000/api/v1/origenes/id/1')
    .then((response) => {
      return response.json();
    }).then((data) => {
      console.log(data);
      let link = 'http://127.0.0.1:8000/storage/'+data.origen.imagen_origen;
      let imagen = `<img src="${link}"></img>`;
      mostrar.innerHTML= imagen;
    }).catch((error) => {
      console.error(error);
    })
```

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 12.- Roles
### *CRUD*
**No hay CRUD para roles ya que el control de rol ya se hace en el registro y en el panel de administrador.**
### *CONSULTAS*
### - obtenerRoles
- Ruta: **api/v1/roles**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los usuarios con los roles que tienen asignados.**
### - tipoRoles
- Ruta: **api/v1/roles/tipos**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve los distintos tipos de roles que hay.**
### - asignarRol
- Ruta: **api/v1/roles/edit/{id}**
- Método: **PUT**
- Parámetros: **ID del usuario al que queremos cambiar el rol**
    ```json
    {
        "role_id": "required|numeric|min:0|max:1" //1(Adminstrador), 2(Cliente)
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos cambia el rol del usuario.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 13.- Tareas
### *CRUD*
### - obtenerTareas
- Ruta: **api/v1/tareas**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todas las tareas.**
### - crearTarea
- Ruta: **api/v1/tareas**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
    "nombre_tarea": "required|string|max:255",
    "asignada_fk": "required|numeric",
    "completado": "required|numeric|min:0|max:1", //Booleano
    "viaje_id": "required|numeric"
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea una tarea.**
### - editarTarea
- Ruta: **api/v1/tareas/{id}**
- Método: **PUT**
- Parámetros: **ID de la tarea que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita la tarea que coincide con el ID.**
### - eliminarTarea
- Ruta: **api/v1/tareas/{id}**
- Método: **DELETE**
- Parámetros: **ID de la tarea que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina la tarea que coincide con el ID.**
### *CONSULTAS*
### - tareaId
- Ruta: **api/v1/tareas/id/{id}**
- Método: **GET**
- Parámetros: **ID de la tarea que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve la tarea que coincide con el ID.**
### - tareaNombre
- Ruta: **api/v1/tareas/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre de la tarea que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve la tarea que coincide con el nombre.**
### - tareaIntegrante
- Ruta: **api/v1/tareas/integrante/{integrante}**
- Método: **GET**
- Parámetros: **ID del integrante de la tarea que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve la tarea que coincide con el ID del integrante.**
### - tareaViaje
- Ruta: **api/v1/tareas/viaje/{viaje}**
- Método: **GET**
- Parámetros: **ID del viaje del cuál queremos consultar sus tareas.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve la/s tarea/s que coincide con el ID del viaje.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 14.- Usuarios
### *CRUD*
### - obtenerUsuarios
- Ruta: **api/v1/usuarios**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todas los usuarios.**
### - crearUsuario
- Ruta: **api/v1/usuarios**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
    "nombre": "required|string|max:255",
    "apellidos": "required|string|max:255",
    "telefono": "required|string|max:15|unique:users,phone_number",
    "correo": "required|email|unique:users,email",
    "contrasenia": "required|string|min:6"
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea una usuario.**
### - editarUsuario
- Ruta: **api/v1/usuarios/{id}**
- Método: **PUT**
- Parámetros: **ID del usuario que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el usuario que coincide con el ID.**
### - editarCorreo
- Ruta: **api/v1/usuarios/correo/{correo}**
- Método: **PUT**
- Parámetros: **Correo del usuario que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el usuario que coincide con el correo.**
### - eliminarUsuario
- Ruta: **api/v1/usuarios/{id}**
- Método: **DELETE**
- Parámetros: **ID del usuario que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos elimina el usuario que coincide con el ID.**
### - eliminarCorreo
- Ruta: **api/v1/usuarios/correo/{correo}**
- Método: **DELETE**
- Parámetros: **Correo del usuario que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos elimina el usuario que coincide con el Correo.**
### *CONSULTAS*
### - usuarioId
- Ruta: **api/v1/usuarios/id/{id}**
- Método: **GET**
- Parámetros: **ID del usuario que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el usuario que coincide con el ID.**
### - usuarioNombre
- Ruta: **api/v1/usuarios/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del usuario que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el usuario que coincide con el nombre.**
### - usuarioApellidos
- Ruta: **api/v1/usuarios/apellidos/{apellidos}**
- Método: **GET**
- Parámetros: **Apellido/s del usuario que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el usuario que coincide con el/los apellido/s.**
### - usuarioCorreo
- Ruta: **api/v1/usuarios/correo/{correo}**
- Método: **GET**
- Parámetros: **Correo del usuario que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el usuario que coincide con el correo.**
### - usuarioTelefono
- Ruta: **api/v1/usuarios/telefono/{telefono}**
- Método: **GET**
- Parámetros: **Telefono del usuario que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el usuario que coincide con el telefono.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 15.- Viajes
### *CRUD*
### - obtenerViajes
- Ruta: **api/v1/viajes**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los viajes.**
### - crearViajeId
- Ruta: **api/v1/viajes**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
    "destino_fk": "required|numeric", //ID del destino
    "origen_fk": "required|numeric", //ID del origen
    "fecha_inicio": "required",
    "fecha_final": "required",
    "numero_integrantes": "required|numeric",
    "vuelo_fk": "required|numeric", //ID de la tabla vuelos
    "hotel_fk": "required|numeric" //ID de la tabla hoteles
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea un viaje.**
### - crearViajeNombre
- Ruta: **api/v1/viajes/nombre**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
    "destino_fk": "required|string", //Nombre del destino
    "origen_fk": "required|string", //Nombre del origen
    "fecha_inicio": "required",
    "fecha_final": "required",
    "numero_integrantes": "required|numeric",
    "vuelo_fk": "required|numeric", //ID de la tabla vuelos
    "hotel_fk": "required|numeric" //ID de la tabla hoteles
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos crea un viaje.**
### - editarViajeID
- Ruta: **api/v1/viajes/{id}**
- Método: **PUT**
- Parámetros: **ID del viaje que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el vije que coincide con el ID.**
### - editarViajeNombre
- Ruta: **api/v1/viajes/usuarios/nombre/{id}**
- Método: **PUT**
- Parámetros: **ID del usuario que queremos editar y un JSON con los datos (como crearViajeNombre).**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos edita el viaje que coincide con el ID.**
### - eliminarViaje
- Ruta: **api/v1/viajes/{id}**
- Método: **DELETE**
- Parámetros: **ID del viaje que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina el viaje que coincide con el ID.**
### *CONSULTAS*
### - viajeId
- Ruta: **api/v1/viajes/id/{id}**
- Método: **GET**
- Parámetros: **ID del viaje que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el viaje que coincide con el ID.**
### - viajeDestinoId
- Ruta: **api/v1/viajes/destino/id/{id}**
- Método: **GET**
- Parámetros: **Nombre del destino que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el viaje que coincide con el destino.**
### - viajeDestinoNombre
- Ruta: **api/v1/viajes/destino/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del destino que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve el viaje que coincide con el destino.**
### - viajeOrigenId
- Ruta: **api/v1/viajes/origen/id/{id}**
- Método: **GET**
- Parámetros: **Nombre del destino que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el viaje que coincide con el destino.**
### - viajeOrigenNombre
- Ruta: **api/v1/viajes/origen/nombre/{nombre}**
- Método: **GET**
- Parámetros: **Nombre del origen que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el viaje que coincide con el origen.**
### - viajeLlegada
- Ruta: **api/v1/viajes/llegada/{fecha}**
- Método: **GET**
- Parámetros: **Fecha de llegada que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el viaje que coincide con la fecha.**
### - viajeSalida
- Ruta: **api/v1/viajes/salida/{fecha}**
- Método: **GET**
- Parámetros: **Fecha de salida que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el viaje que coincide con la fecha.**
### - viajeIntegrantes
- Ruta: **api/v1/viajes/integrantes/{integrantes}**
- Método: **GET**
- Parámetros: **Numero de integrantes que van a un viaje que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el viaje que coincide con el numero de integrantes.**
### - viajeUser
- Ruta: **api/v1/viajes/usuario/{id}**
- Método: **GET**
- Parámetros: **ID del usuario del cual queremos consultar sus viajes**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos devuelve todos sus viajes.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 16.- Vuelos
### *CRUD*
### - obtenerVuelos
- Ruta: **api/v1/vuelos**
- Método: **GET**
- Parámetros: **Ninguno**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve todos los vuelos.**
### - crearVuelo
- Ruta: **api/v1/vuelos**
- Método: **POST**
- Parámetros: **Un JSON con los datos que queremos almacenar:**
    ```json
    {
    "vuelo_origen": "required|numeric", //ID de la tabla origen_vuelos
    "vuelo_destino": "required|numeric" //ID de la tabla destino_vuelos
    }
    ``` 
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos crea un vuelo y nos devuelve el vuelo con su ID creado.**
### - editarVuelo
- Ruta: **api/v1/vuelos/{id}**
- Método: **PUT**
- Parámetros: **ID del vuelo que queremos editar y un JSON con los datos (como crear).**
- Token: **Obligatorio**
- Acceso: **Admin/Cliente**
- Respuesta: **Nos edita el vuelo que coincide con el ID.**
### - eliminarVuelo
- Ruta: **api/v1/vuelos/{id}**
- Método: **DELETE**
- Parámetros: **ID del vuelo que queremos eliminar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos elimina el vuelo que coincide con el ID.**
### *CONSULTAS*
### - vueloId
- Ruta: **api/v1/vuelos/{id}**
- Método: **GET**
- Parámetros: **ID del vuelo que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el vuelo que coincide con el ID.**
### - vueloOrigen
- Ruta: **api/v1/vuelos/origen/{origen}**
- Método: **GET**
- Parámetros: **ID del origen del vuelo que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el vuelo que coincide con el ID del origen.**
### - vueloDestino
- Ruta: **api/v1/vuelos/destino/{destino}**
- Método: **GET**
- Parámetros: **ID del destino del vuelo que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el vuelo que coincide con el ID del destino.**
### - vueloPrecio
- Ruta: **api/v1/vuelos/precio/{precio}**
- Método: **GET**
- Parámetros: **Precio del vuelo que queremos consultar.**
- Token: **Obligatorio**
- Acceso: **Admin**
- Respuesta: **Nos devuelve el vuelo que coincide con el precio.**

<!-- ----------------------------------------------------------------------------------------------------------------------------------- -->

## 17.- APIS EXTERNAS
### Mirar la documentacion oficial, esto es un breve resumen
### - Hoteles
#### - Paso 1:
- Ruta: **https://tripadvisor16.p.rapidapi.com/api/v1/hotels/searchLocation?query=Alcorcon**
- Método: **GET**
- Parámetros: **Nombre de la ciudad donde queremos buscar los hoteles**
    ```javascript
    {
        const url = 'https://tripadvisor16.p.rapidapi.com/api/v1/hotels/searchLocation?query=Alcorcon';
        const options = {
            method: 'GET',
            headers: {
                'x-rapidapi-key': KEY,
                'x-rapidapi-host': 'tripadvisor16.p.rapidapi.com'
            }
        };

        try {
            const response = await fetch(url, options);
            const result = await response.text();
            console.log(result);
        } catch (error) {
            console.error(error);
        }
    }
    ```
- Token: **Tienes que registrarte en la web**
- Respuesta: **Nos devuelve los datos de esa ciudad, tenemos que almacenar el campo geoId.**
**El valor que retorna en geoId tendremos que usarlo para obtener la consulta de los hoteles**
#### - Paso 2:
- Ruta: **https://tripadvisor16.p.rapidapi.com/api/v1/hotels/searchHotels?geoId=562646&checkIn=2025-04-04&checkOut=2025-04-07&pageNumber=1&currencyCode=USD**
- Método: **GET**
- Parámetros: **Id de la ciudad donde queremos buscar los hoteles (geoId del paso anterior), fecha de entrada y salida, pageNumber y currencyCode**
    ```javascript
    {
        const url = 'https://tripadvisor16.p.rapidapi.com/api/v1/hotels/searchHotels?geoId=562646&checkIn=2025-04-04&checkOut=2025-04-07&pageNumber=1&currencyCode=USD';
        const options = {
            method: 'GET',
            headers: {
                'x-rapidapi-key': KEY,
                'x-rapidapi-host': 'tripadvisor16.p.rapidapi.com'
            }
        };

        try {
            const response = await fetch(url, options);
            const result = await response.text();
            console.log(result);
        } catch (error) {
            console.error(error);
        }
    }
    ```
- Token: **Tienes que registrarte en la web**
- Respuesta: **Nos devuelve los hoteles de esa ciudad**
#### - Paso 3:
**Los datos que vamos a pillar de esta API son solo:**
- data/data/
    1. Title
    2. secondaryInfo
    3. bubbleRating/
        - rating
    4. provider
    5. priceForDisplay
    6. commerceInfo/
        - externalUrl
### - Vuelos
#### - Paso 1:
#### **Tendremos que registrarnos, crear una API KEY para el usuario y luego otra API KEY para poder realizar las peticiones de los vuelos**
#### - Documentacion de cómo obtener el token:
**https://developers.amadeus.com/self-service/apis-docs/guides/developer-guides/API-Keys/authorization/**
#### - Petición de ejemplo:
**https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=MAD&destinationLocationCode=LON&departureDate=2025-04-07&returnDate=2025-04-22&adults=2&max=5**
```javascript
    {
    fetch('https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=MAD&destinationLocationCode=LON&departureDate=2025-04-07&returnDate=2025-04-22&adults=2&max=5', {
    method: 'GET',
    headers: {
        'Authorization': 'Bearer <tu_access_token>' // Reemplaza con tu token de acceso (Bearer token)
    }
    })
    .then(response => response.json())  // Convierte la respuesta a JSON
    .then(data => console.log(data))  // Muestra los datos en la consola
    .catch(error => console.error('Error:', error));  // Muestra errores si los hay
    }
```
- Token: **Tienes que registrarte en la web**
- Respuesta: **Nos devuelve los viajes a esa ciudad**
**Los datos que vamos a pillar de esta API son solo:**
- data/
    1. itineraries/segments
    **(Hay 2 segments, el primero es el vuelo de ida (origen_vuelos) y el segundo es el de vuelta (destino_vuelos), pillamos los dos)**
        - /departure
            - terminal
            - at
        - /arrival
            - terminal
            - at
        - carrierCode
        - /aircraft
            - code

    **(En la BD, el campo origen_vuelo es carrierCode + code para crear el nombre completo del avion)**

    2. /price
        - total
    3. travelerPricings/price **(Dentro de travelerPircings hay 2 objetos, uno es el coste del billete de ida y otro el coste del billete de vuelta, pillamos los dos)**
        - total

    **Puede que algunosvuelos tengan trasbordo como puede ser Lisboa-Paris, que hace trasbordo en Madrid, los datos del vuelo que sale de Madrid no lo pillamos, hacemos como que va directo Lisboa-Paris**