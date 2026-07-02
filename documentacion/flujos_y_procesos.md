# Documentación de Flujos y Procesos del Sistema

Este documento describe detalladamente los flujos de trabajo críticos de **GD2.0 (Gestor de Documentos)**, ilustrados mediante diagramas de secuencia y diagramas de flujo.

---

## 1. Flujo de Autenticación y Control de Acceso

Este proceso asegura que los usuarios que ingresan al sistema cuenten con una sesión activa y válida, y carga los permisos específicos del rol del usuario para restringir las funciones del menú lateral.

```mermaid
sequenceDiagram
    autonumber
    actor Usuario
    participant Navegador as Navegador Web
    participant Control as controller.php (validarsesion)
    participant DB as Base de Datos (users / sesionusuario)

    Usuario->>Navegador: Ingresa credenciales en signin.php
    Navegador->>Control: Solicita login (POST)
    Control->>DB: Verifica RUT y contraseña
    alt Credenciales incorrectas
        DB-->>Control: No coincide
        Control-->>Navegador: Retorna error de login
        Navegador-->>Usuario: Muestra mensaje "Usuario o clave incorrecta"
    else Credenciales válidas
        DB-->>Control: Registro de usuario y tipo
        Control->>DB: Registra token en tabla sesionusuario
        Control->>Navegador: Guarda USER_ID y USER_TOKEN en $_SESSION
        Navegador->>Navegador: Redirecciona a index.php
    end

    Note over Navegador, Control: Validación en cada carga de página (index.php)
    Navegador->>Control: Envía USER_ID y USER_TOKEN (Session)
    Control->>DB: Consulta sesión activa y permisos (permisosusers)
    DB-->>Control: Retorna permisos del usuario (Lectura/Escritura/Gestión...)
    Control-->>Navegador: Habilita u oculta opciones del menú
```

---

## 2. Proceso de Registro de un Trabajador (Ficha de Empleado)

La creación de un trabajador en la base de datos es un proceso estructurado para garantizar que los datos personales, previsionales y contractuales sean consistentes.

```mermaid
flowchart TD
    A([Inicio: Registrar Trabajador]) --> B[Ingresar Datos Básicos: RUT, Nombre, Sexo, Civil]
    B --> C[Asignar Empresa Empleadora]
    C --> D[Guardar Trabajador en Tabla 'trabajadores']
    D --> E{¿Guardado con éxito?}
    E -- No --> F[Retornar Error de Registro]
    E -- Sí --> G[Ingresar Datos de Contacto en 'trabajadorcontacto']
    G --> H[Ingresar Dirección en 'trabajadordomicilio']
    H --> I[Asignar Cargo en 'trabajadorcargo']
    I --> J[Asignar Remuneración y Tipo de Sueldo en 'trabajadorremuneracion']
    J --> K([Fin: Trabajador Listo para Contratación])
```

---

## 3. Flujo de Creación y Aprobación de Contrato (V2.0)

Este proceso implementa una separación clara entre la generación visual del documento PDF y la escritura definitiva en la base de datos (evitando registros inconsistentes o basura en el disco).

```mermaid
sequenceDiagram
    autonumber
    actor Usuario
    participant JS as JsFunctions/contrato.js
    participant PHP_Preview as generarcontratoindividual.php
    participant PHP_Confirm as confirmarcontrato.php
    participant DB as Base de Datos

    Usuario->>JS: Completa formulario y click en "Generar Contrato"
    JS->>JS: Ejecuta validaciones locales (días de trabajo, domingos, subcontratación)
    
    alt Datos inválidos
        JS-->>Usuario: Muestra alerta de validación
    else Datos válidos
        JS->>PHP_Preview: Envía datos por POST AJAX
        PHP_Preview->>PHP_Preview: Procesa variables y redacta PDF en memoria (mPDF)
        PHP_Preview->>PHP_Preview: Guarda datos del contrato en $_SESSION['contrato_preview']
        PHP_Preview-->>JS: Retorna el PDF codificado en Base64
        JS->>Usuario: Abre Modal y muestra el PDF en un Iframe (Vista Previa)
        
        alt Usuario Rechaza / Cancela Vista Previa
            Usuario->>JS: Click en "Cancelar"
            JS->>Usuario: Cierra Modal (el contrato no se guarda en BD)
        else Usuario Confirma Contrato
            Usuario->>JS: Click en "Confirmar y Guardar"
            JS->>PHP_Confirm: Envía confirmación por AJAX
            PHP_Confirm->>PHP_Confirm: Valida sesión temporal (máximo 30 minutos)
            PHP_Confirm->>PHP_Confirm: Guarda el PDF físico en disco (uploads/Contratos/)
            PHP_Confirm->>DB: Inserta registro principal en tabla 'contratos'
            PHP_Confirm->>DB: Inserta distribución horaria diaria en 'contrato_distribucion_horaria'
            PHP_Confirm->>DB: Inserta zonas geográficas y estipulaciones adicionales
            PHP_Confirm->>PHP_Confirm: Limpia $_SESSION['contrato_preview']
            PHP_Confirm-->>JS: Retorna resultado exitoso (JSON)
            JS->>Usuario: Muestra Toast de éxito y redirecciona a contratos.php
        end
    end
```

---

## 4. Proceso de Cálculo de Remuneraciones Mensual

Este proceso consolida los haberes fijos del trabajador, la asistencia mensual (días laborados, faltas, licencias) y calcula los montos a pagar del período.

```mermaid
flowchart TD
    A([Inicio Período Remuneraciones]) --> B[Seleccionar Mes y Empresa]
    B --> C[Cargar Asistencia de Trabajadores: Asistencia e inasistencias]
    C --> D[Obtener Haberes y Descuentos del Trabajador desde 'haberes_descuentos_trabajador']
    D --> E[Procesar Trabajadores: Calcular Sueldo Base Imputable]
    E --> F[Aplicar descuentos previsionales: AFP, Salud, seguro de cesantía]
    F --> G[Calcular Impuesto Único de Segunda Categoría a partir de tramos UTM]
    G --> H[Calcular Asignación Familiar si aplica según tramos e ingresos]
    H --> I[Obtener Sueldo Líquido del Período]
    I --> J[Registrar Liquidación de Sueldos en tabla 'liquidaciones']
    J --> K[Insertar Desglose en tabla 'detalle_liquidacion']
    K --> L[Generar Libro de Remuneraciones Electrónico LRE]
    L --> M([Fin del Período Remuneraciones])
```
