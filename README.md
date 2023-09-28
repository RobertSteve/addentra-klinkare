# Prueba Técnica - Addentra Klinkare

## Requerimientos
- Docker

## Instalación
Este proyecto esta dockerizado.

### Estructura de carpeta
```
--- retos
---- src
----- Challenge
------ One
------ Two
----- Exceptions
----- Services
---- tests
```
### Testing
Para ejecutar las pruebas unitarias, ejecutar el siguiente comando:
```
vendor/bin/phpunit
```

### Ejecución
Para ejecutar el proyecto, ejecutar el siguiente comando:

```
Entrar a la carpeta src
cd src/
Para ejecutar el reto 1 colocar el siguiente comando
php challengeOne.php
Para ejecutar el reto 2 colocar el siguiente comando
php challengeTwo.php

### Observaciones
- El reto 1 para su realización se aumenta la memoria a 3G, ya que consume mucho.
- El reto 2 para que salga el resultado de acuerdo al Output del pdf, detecte que el primer bloque se inicializa el 
array en vacio [] y para los otros bloques lo estoy inicializando con 0 = [0].
Luego descubrí el desplazamiento de esta incializacion en su indice pasar este 0 al último de la posicion 0.

