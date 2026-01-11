📦app
 ┣ 📂Application                      # Capa de aplicación: coordina casos de uso, sin lógica de negocio
 ┃ ┣ 📂DTOs                             # Objetos para transportar datos entre capas (input/output del UseCase)
 ┃ ┣ 📂UseCases                         # Acciones del sistema (login, crear envío, registrar cliente, etc.)
 ┃ ┗ 📂Validators                       # Validación simple de entrada (NO son FormRequest y NO es dominio)

 ┣ 📂Domain                           # Capa de dominio: la lógica de negocio pura
 ┃ ┣ 📂Entities                        # Objetos del negocio (User, Shipment, Route...). Reglas dentro
 ┃ ┣ 📂Events                          # Eventos del dominio (UserLoggedIn, ShipmentCreated)
 ┃ ┣ 📂Exceptions                      # Excepciones 100% de negocio, no HTTP
 ┃ ┣ 📂Interfaces                      # Interfaces del dominio (repos y servicios que infra implementa)
 ┃ ┣ 📂Policies                        # Reglas de autorización del dominio (ej: empleado puede ver X)
 ┃ ┗ 📂Services                        # Lógica compleja de negocio (calcular costo del envio)
 ┃ ┣ 📂ValueObjects                    # Objetos con reglas inmutables (Email, Price, UUID, Distance)

 ┣ 📂Infrastructure                   # Capa infra: HTTP, DB, servicios externos, eventos, adaptadores
 ┃ ┣ 📂Database                       # Seeders y factories adicionales, migraciones
 ┃ ┣ 📂Events                         # Listeners concretos
 ┃ ┣ 📂Http                            # Todo lo relacionado con HTTP (controladores, requests)
 ┃ ┃ ┣ 📂Controllers                    # Controladores que llaman UseCases y devuelven Responses
 ┃ ┃ ┣ 📂Middleware                     # Middleware HTTP
 ┃ ┃ ┣ 📂Requests                       # Validación HTTP con FormRequest
 ┃ ┃ ┣ 📂Resources                      # Transforma data → JSON
 ┃ ┃ ┗ 📂Responses                      # Plantillas estándar de API (ApiSuccess, ApiError)
 ┃ ┣ 📂Repositories                    # Implementación concreta de los repos del dominio (DB)
 ┃ ┣ 📂Services                       # Servicios externos (email)

 📂Shared                         # Utilidades compartidas para todas las capas
 ┃ ┗ 📂Contracts                      # Interfaces transversales
 ┃ ┣ 📂Enums                          # Enums compartidos (estados, roles, tipos)
 ┃ ┣ 📂Helpers                        # Funciones de ayuda (fechas, strings, etc.)
 ┃ ┣ 📂Traits                         # Traits reutilizables

 ┣ 📂Tests                          # Tests del sistema
 ┃ ┣ 📂Unit                           # Tests unitarios del dominio y application
 ┃ ┣ 📂Feature                        # Tests de casos completos (HTTP, flujos)
 ┃ ┗ 📂Integration                    # Tests que prueban módulos juntos (DB, eventos, colas) 
