# Connected School Services - Backend part 

## **_Project's display_**

Connected School Services is a digital services plateform, that brings together all interactions and communications, that could be between a student( or parents for the youngest students), the school and its teachers / administration.

This is the backend of the application ( Full Symfony ) : 
 - One part is an API Restfull that the front side will pick the endpoints that he needs
 - Another part is the backoffice for the administration of the school, to manage students / teachers & classrooms


## **_Dependencies to install :_**

- fzaninotto/faker : `composer require fzaninotto/faker`
- ORM Fixtures : `composer require --dev orm-fixtures`
- Nelmio Cors : `composer require nelmio/cors-bundle`
- JWT Lexik : `composer require lexik/jwt-authentication-bundle`
- Swift Mailer : `composer require symfony/swiftmailer-bundle`
- Apache-Pack : `composer require symfony/apache-pack`
- Vich Uploader : `config/packages/vich_uploader.yaml`

[Tuto Uploader API](Docs/uploader-API.md)

## **_Technical Specifications :_**

### Technologies :

- PHP Symfony
- Maria-DB SQL
- Adminer

  
### Technical constraints :

- Responsive website in mobile-first
- Compatibility with Chrome / Edge / Firefox / Safari browsers 
