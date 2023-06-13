# ProcessWire-ObjectDimension-Fieldtype
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![ProcessWire 3](https://img.shields.io/badge/ProcessWire-3.x-orange.svg)](https://github.com/processwire/processwire)

An inputfield and fieldtype for the ProcessWire CMS to enter dimensions (length, width and height) of an object.

This fieldtype was inspired by the amazing fieldtype "Fieldtype Dimensions" from SOMA ([https://modules.processwire.com/modules/fieldtype-dimension/](https://modules.processwire.com/modules/fieldtype-dimension/)). This fieldtype was introduced in 2013 - so its time for a relaunch.
This new fieldtype offers more possibilities than the old one from SOMA.

**The main differences**<br />
You can select if 2 dimensions (length and width) or 3 dimension (length, width and height) should be displayed. 2 dimensions can be used for photos, wallpapers and so on. 3 dimensions for other objects.
You can enter the dimension values as float numbers or as integers (depending on the number of decimals set in the field configuration)

The code uses also some parts and ideas from the Fieldtype Decimals ([https://modules.processwire.com/modules/fieldtype-decimal/](https://modules.processwire.com/modules/fieldtype-decimal/)) - especially methods for altering the database schema.

## What it does

This inputfield/fieldtype let you enter 2 or 3 dimension values of an object (fe a product) and calculates and stores the volume and the area.
All of the dimension values are fully searchable, so if you create a filter function you can grab all products with fullfill certain dimensions (fe show me all products where the length is lower than 100 cm and the width is lower than 30 cm).

### 2 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/objectdimensions1.png?raw=true)

### 3 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/objectdimensions2.png?raw=true)

### Output values of each dimension on the frontend

Afterwards you will find the properties on how to output the dimension values on the frontend. Please replace "fieldname" with the name of your input field.

#### Default values

There's a property for each dimension, which outputs the dimension including the unit (fe cm) as set inside the field configuration. So this properties always return a string.

```
echo $page->fieldname->lenght; // outputs fe 2 cm
echo $page->fieldname->width; // outputs fe 3 cm
echo $page->fieldname->height; // outputs fe 2 cm
echo $page->fieldname->area; // outputs fe 6 cm²
echo $page->fieldname->volume; // outputs fe 12 cm³
```

#### Output default value including the unit

If you want to output the label of each dimension in front of the value too, you have to use the following properties:

```
echo $page->fieldname->lenghtLabel; // outputs fe Length: 2 cm
echo $page->fieldname->widthLabel; // outputs fe Width: 3 cm
echo $page->fieldname->heightLabel; // outputs fe Height: 2 cm
echo $page->fieldname->areaLabel; // outputs fe Area: 6 cm²
echo $page->fieldname->volumeLabel; // outputs fe Volume: 12 cm³
```
As you can see, you only have to add the word "Label" after the dimension name to output the dimension including the label. 

#### Output raw values as stored inside the database
If you want to get the raw values as they are stored inside the database, you have to call the properties like this:

```
echo $page->fieldname->lenghtUnformatted; // outputs 2
echo $page->fieldname->widthUnformatted; // outputs fe 3
echo $page->fieldname->heightUnformatted; // outputs fe 2
echo $page->fieldname->areaUnformatted; // outputs fe 6
echo $page->fieldname->volumeUnformatted; // outputs fe 12
```
As you can see, the output will be only a number of type int or float and not a string

#### Output the unit 
If you need to output the unit (fe cm) on the frontend, then use the following call:

```
echo $page->fieldname->unit; // outputs fe cm
```
This outputs the unit as a string (fe cm).

### Additional render methods

#### renderDimensions()
This will render a formatted string containing all dimensions.

```
echo $page->fieldname->renderDimensions(); 
```
will produce fe the following output:

```
0.12 cm (L) * 0.35 cm (W) * 3.75 cm (H)
```

For further customization you can enter 2 additional parameters inside the brackets:

- The first one for displaying the label (default is false).
- The second parameter is for the multiplication sign (default is "*"), 

```
echo $page->fieldname->renderDimensions(true, 'x');
```
will produce fe the following output:

```
Dimensions: 0.12 cm (L) x 0.35 cm (W) x 3.75 cm (H)
```
As you can see the label will be displayed in front of the values and the multiplication sign has changed from "** to "x".

#### renderAll()
This will render a combined formatted string containing all dimensions, area and volume as an unordered list.

```
echo $page->fieldname->renderAll();
```
will output fe
```
Dimensions: 3 cm (L) x 4 cm (W) x 2 cm (H)
Area: 12 cm²
Volume: 24 cm²
```

You can get the same result with this call, which is equal to the _toString method():

```
echo $page->fieldname;
```

The renderAll() method supports the multiplication sign as parameter (like the renderDimensions() method)  inside the parenthesis.

```
echo $page->fieldname->renderAll('x');
```

This replaces the default "*" with the "x" in this case.



### Find pages by using selectors

As written in the introduction all the dimensions are fully searchable. Here are 2 examples on how to query.

The dimensions can be used in selectors like:

`$pages->find("fieldname.width=120");`

or

`$pages->find("fieldname.height>=100, fieldname.depth<120");`

or

`$pages->find("fieldname.volume>=1000");`

### Field Settings

There are several configuration options for this fieldtype in the backend.

- set type (2 or 3 dimensional)
- set size unit as suffix after each inputfield (default is cm)
- set max number of digits that can be entered in each field (default is 10)
- set max number of decimals (default is 2)
- show/hide a hint to the user how much digits/decimals are allowed

Some of the configurations settings can also be changed separately on per template base too.

If the number of decimals will be changed, the database schema for each dimension column will also change (float/integer).

For example:
If the schema for each dimension field in the DB is f.e. decimal(10,2) and you will set the number of digits in the configuration to 12 and the number of decimals to 1, then the schema in the DB will also change to decimal(12,1) after saving the inputfield.

If a number of 0 for decimals will be choosen, then the schema will automatically change from float to integer in the DB.

In addition a small JavaScript prevents the user from entering more decimals into the inputs than set in the configuration of this fieldtype.
Fe. if you set the number of decimals to 2, than the user cannot enter more than 2 decimals in the inputfield

## How to install

1. Download and place the module folder named "FieldtypeObjectDimensions" in:
/site/modules/

2. In the admin control panel, go to Modules. At the bottom of the
screen, click the "Check for New Modules" button.

3. Now scroll to the FieldtypeDimension module and click "Install". The required InputfieldObjectDimension will get installed automatic.

4. Create a new Field with the new "ObjectDimension" Fieldtype.
