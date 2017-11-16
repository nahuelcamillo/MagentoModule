# MagentoModule

Modulo básico que genera un método de envío en el cual se brinda envío gratis si un usuario realiza la compra en el día de su cumpleaños.

Para la instalación de este módulo deben seguirse los siguientes pasos:

1. Deshabilitar la cache.
   En el backend, con el usuario administrador, ir a Admin -> System -> Cache Management. Seleccionar todos y luego deshabilitarlas.
   
2. Poner a Magento en modo desarrollador
   Para ello debe abrirse una terminal en la carpeta raíz de la instalación de nuestro Magento y ejecutar el siguiente comando: php bin/magento deploy:mode:set developer
   
3. Crear un namespace
   Los namespasce se generan en la carpeta: app/code/"namespace". Por ejemplo app/code/PrimerModulo
   
4. Generar la carpeta del módulo
   Los módulos se deben crear dentro del namespace. En este caso sería app/code/PrimerModulo/bdayfreeshipping
   
5. Colocar los archivos que se encuentran en este repositorio dentro de la última carpeta creada.

6. Una vez creado un módulo, el mismo debe activarse a través del siguiente comando en la terminal: php -f /bin/magento module:enable

7. Para activar la solicitud de fecha de cumpleaños al momento de crear un usuario se debe realizar lo siguiente:
   Dentro del módulo de administración. Stores -> Configuration -> Customers -> Customer configuration -> Name and Address options -> Show date of birth, se debe pasar a “Required”.
