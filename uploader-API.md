# Vich Uploader pour API

## Installation & config

Tout d'abord pour installer le bundle, *mettre **yes** dans la demande d'install de recipe* : `composer require vich/uploader-bundle`

Ensuite aller dans `config/packages/vich_uploader.yaml` 

Mettre `orm` dans le `db_driver`, décommenter la section du bas afin de configurer le dossier ou sera uploadé les documents. Ce qui donnera ceci :

```yaml
# config/packages/vich_uploader.yaml or app/config/config.yml
vich_uploader:
    db_driver: orm

    mappings:
        product_image:
            uri_prefix: /images/products
            upload_destination: '%kernel.project_dir%/public/images/products'
            namer: Vich\UploaderBundle\Naming\SmartUniqueNamer
```

La dernière étape consiste à créer un lien entre le système de fichiers et l'entité que vous souhaitez rendre téléchargeable.

Tout d'abord dans l'Entity souhaitée, il faut annoter la classe avec l'annotation `Uploadable`

Ensuite créer deux champs nécéssaires au fonctionnement du bundle :

1. Créer un champ qui sera stocké en string dans la BDD, qui contiendra le nom du fichier, *comme `imageName` par exemple*
2. Créer un autre champ qui stockera l'objet de classe `UploadedFile` après soumission du formulaire, *par exemple `imageFile` qui lui ne sera pas persist à la BDD, mais qui doit être annoté*

L'annotation `UploadableField` a quelques options :

- **mapping**: obligatoire, le nom de mappage spécifié dans la configuration du bundle à utiliser
- **fileNameProperty**: obligatoire, la propriété qui contiendra le nom du fichier uploadé
- **size**: la propriété qui contiendra la taille en octets du fichier uploadé
- **mimeType**: la propriété qui contiendra le type mime du fichier uploadé
- **originalName**: la propriété qui contiendra le nom d'origine du fichier téléchargé
- **dimensions**: la propriété qui contiendra les dimensions du fichier image téléchargé

Rajouter à la mano dans son Entity un variable private qui prendra des paramètres en annotations de Vich, mais qui sera pas une entrée de BDD, comme cité au dessus comme ceci : 

```php
/**
 * @Vich\UploadableField(mapping="product_image", fileNameProperty="image")
 *
 * @var File|null
 */
private $imageFile;
```

Donc le mapping, pour situer le dossier d'upload, et fileNameProperty, le champ de BDD qui stockera le nom. On peut lier d'autres options, *voir la liste ci-dessus*
