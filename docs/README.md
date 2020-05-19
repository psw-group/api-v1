# PSW GROUP API Documentation

The API is organized around REST. It accepts JSON-encoded request bodies, returns JSON-encoded responses and uses standard HTTP response codes and verbs.

The following response formats are available:

| Name      | Media type                |
|-----------|---------------------------|
| JSON-LD   | application/ld+json       |
| HAL+JSON  | application/hal+json      |
| JSON:API  | application/vnd.api+json  |
| JSON      | application/json          |

You can find an OpenAPI 3 documentation at: https://test-api.psw-group.de/v1  

## Endpoints

| Path                              | Resource creation | Description    |
|-----------------------------------|----------|-------------------------|
| /certificate-authorities          | no       | Certificate authorities<br><sub>Example: Sectigo, Digicert, Certum|
| ​/certificate-states               | no       | States of certificates<br><sub>Example: new, valid, revoked</sub> |
| ​/certificate-types                | no       | Types of certificates<br><sub>Example: SSL, S/MIME, code signing</sub> | 
| ​/certificate-validation-methods   | no       | Methods of validation for certificates<br><sub>Example: E-Mail, HTTP, DNSTXT</sub> | 
| ​/certificate-validation-types     | no       | Types of validation of certificates<br><sub>Example: DV, OV, EV</sub> | 
| ​/certificates                     | indirect | Certificates | 
| ​/contacts                         | yes      | Contacts for orders or certificates | 
| ​/countries                        | no       | Countries<br><sub>Example: DE, AT, CH</sub> | 
| ​/currencies                       | no       | Currencies<br><sub>Example: EUR, USD, CHF</sub> | 
| ​/jobs                             | yes      | Jobs | 
| ​/order-states                     | no       | States of orders<br><sub>Example: open, processing, complete</sub> | 
| ​/orders                           | yes      | Orders| 
| ​/organisation-types               | no       | Organisation types for contacts<br><sub>Example: Im Handelsregister eingetragene Firma, Privatperson</sub> | 
| /products                         | no       | Products sold by PSW GROUP<br><sub>Example: Sectigo Lite 30 day trial</sub> | 
| ​/users                            | yes      | Users of your account | 

---
Weitere Themen auf Deutsch: [Übersicht](de/README.md) 
