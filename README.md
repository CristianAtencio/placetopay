# Pueba PlaceToPay
En este repositorio se encuentra el resultado total de la prueba de integración de los pagos a través de la plataforma de PlaceToPay.

# 1. Integración de pagos basicos:
Para este puento considero que se implemento de manera correcta buscando seguir los requerimientos de la planteanión del punto, se accedio de correcta forma a el api de placetopay, haciendo todo el recorrido para realizar el pago, desde la autenticación, envio de petición y redirección al final de proceso a la plataforma del comercio dejando ver el resultado de la operación. por cuestiones de tiempo no se puedo implementar las pruebas unitarias las cuales tenia planteado hacer con PHPUNIT, ademas de cuestiones esteticas mejorando la interfaz del comercio tanto en el formulario como respuesta al finalizar el proceso y por la parte del backend de se podrian refactorizar algunas funciones de los controladores que se comparten entre los dos que actualmente existen, de igual forma en los modelos.

# 2. Diagramas de secuencia Pago Mixto y Suscripción
Se encuentra adjunto en el repositorio como dos imagenes png con los nombre:
  DiagramadeSecuenciaPagoMixto.png
  DiagramadeSecuenciaSuscripcion.png

# 3. Definición de atributos
  - Autenticación: Proceso de identificación o validación de un usuario con el fin de acceder a consumir determinados servicios.
  - Suscripción: Forma o porceso en el cual a fin de agilizar una acción o proceso (pagos), se define una información basica y es almacenada  para futuras acciones del mismo tipo(pagos), para facilitar y hacer mas rapidos los procesos repetitivos, los pagos por ejemplo.
  - Token: Es un valor o dato generado para realizar un proceso o cosumir un servicio, es un valor unico y propio de un proceso determinado, este puede tener un tiempo determinado de uso y sirve como una autenticaón temporal unica.
  - Subtoken: Es un valor numerico derivado de un token para determinado consumo de servicios que lo requieran.(sus ultimos 4 digitos serian los ultimos 4 digitos de una tarjeta de credito).
  - Pago Mixto: Servicio o proceso que permite dividir un pago entre diferentes medios o formas de pagos(realizar un pago total dividido en varios pagos menores)
  - Login: Proceso de indentificaión individual de un usuario en un aplicativo con unas credenciales unicas.
  - ProcessUrl: dirección url con la cual redireccionar para procegir a terminar el proceso de pago.
  - ReturnUrl: Url final del proceso realizado en una pasarela de pago y hace parte del comercio que consume el proceso de pago online para sus clientes.
  - ¿Para que usaria un pago recurrente?: Cuando se debe realizar un mismo pago en repetidas ocasiones a travez del tiempo (En teoria un mismo pago o transacción cada cierto tiempo).
  - ¿Para que usaria una suscripción?: Si constantemente se recurre o se realizan diferentes transacciones por un mismo medio(si consumo mucho por internet y siempre o casi siempre pago por PlaceToPay por ejemplo).
  
 Gracias por tenerme en cuenta para realizar esta prueba.
