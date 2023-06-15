# ProcessWire-ObjectDimension-Fieldtype
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![ProcessWire 3](https://img.shields.io/badge/ProcessWire-3.x-orange.svg)](https://github.com/processwire/processwire)

An inputfield and fieldtype for the ProcessWire CMS to enter dimensions (length, width and height) of an object and to 
calculate area and volume automatically.

This fieldtype was inspired by the amazing fieldtype "Fieldtype Dimensions" from SOMA, and it was introduced in 
2013, but it is probably no longer available - so it's time for a relaunch.
This new fieldtype comes with some additional features.

## Requirements
* PHP>=8.0.0
* ProcessWire>=3

## Purpose of this inputfield

This inputfield/fieldtype let you enter 2 or 3 dimension values (length, width, height) of an object (fe a product) and 
calculates and stores the volume and the area too.
All the dimension values including area and volume are fully searchable. A daily life example could be a product 
page, where you can display the product dimensions.

## Benefits
* Calculates area and volume automatically, and these values are fully searchable too (beside the other dimensions)
* Easy to use API for outputting various formats of the dimensions (raw format from the database, value including unit, value including label)
* Reduced code in templates to output the values  
* Only one additional database table instead of multiple for storing the 5 values (length, width, height, area, volume)
* Nice configurable one line user interface in the backend
* Multiple configuration settings in the backend to adapt the inputfield to your needs

## Views of the inputfield in the backend
Afterwards you will see how the inputfield looks like as 2 or 3-dimensional input.

### inputfield view: 2 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/2d.png?raw=true)

### inputfield view: 3 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/3d.png?raw=true)

## Output values of each dimension on the frontend

Afterwards you will find the properties on how to output the dimension values on the frontend. Please replace
"fieldname" with the name of your inputfield.
Each dimension will be stored inside a column of the database.

![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/database.png?raw=true)

### Default values

According to the database entries as illustrated in the previous image, there's a property for each dimension, which
outputs the dimension including the unit (fe cm) as set inside the field configuration. So these properties always 
return a string.

```
echo $page->fieldname->lenght; // outputs fe 2 cm
echo $page->fieldname->width; // outputs fe 3 cm
echo $page->fieldname->height; // outputs fe 2 cm
echo $page->fieldname->area; // outputs fe 6 cm²
echo $page->fieldname->volume; // outputs fe 12 cm³
```

### Output default value including the label

If you want to output the label of each dimension in front of the value too, you have to use the following property
calls:

```
echo $page->fieldname->lenghtLabel; // outputs fe Length: 2 cm
echo $page->fieldname->widthLabel; // outputs fe Width: 3 cm
echo $page->fieldname->heightLabel; // outputs fe Height: 2 cm
echo $page->fieldname->areaLabel; // outputs fe Area: 6 cm²
echo $page->fieldname->volumeLabel; // outputs fe Volume: 12 cm³
```
As you can see, you only have to add the word "Label" after the dimension name to output the dimension including the
label. 

### Output raw values as stored inside the database
If you want to get the raw values as they are stored inside the database, you have to use these property calls:

```
echo $page->fieldname->lenghtUnformatted; // outputs 2
echo $page->fieldname->widthUnformatted; // outputs fe 3
echo $page->fieldname->heightUnformatted; // outputs fe 2
echo $page->fieldname->areaUnformatted; // outputs fe 6
echo $page->fieldname->volumeUnformatted; // outputs fe 12
```
As you can see, you only have to add the word "Unformatted" after the dimension name to output the raw value as integer
or float. 

### Output the unit 
If you need to output the unit (fe cm) on the frontend, then you have to use the following property call:

```
echo $page->fieldname->unit; // outputs fe cm
```
This outputs the unit as a string (fe cm).

### Additional render methods

This fieldtype includes 2 useful additional rendering methods, which are described afterwards.

#### renderDimensions()
This will render a formatted string containing all dimensions.

```
echo $page->fieldname->renderDimensions(); 
```
will produce fe the following output:

```
0.12 cm (L) * 0.35 cm (W) * 3.75 cm (H)
```

For further customization, you can enter 2 additional parameters inside the brackets:

- The first one for displaying the label (default is false).
- The second parameter is for the multiplication sign (default is "*"). 

```
echo $page->fieldname->renderDimensions(true, 'x');
```
will produce fe the following output:

```
Dimensions: 0.12 cm (L) x 0.35 cm (W) x 3.75 cm (H)
```
As you can see, the label will be displayed in front of the values and the multiplication sign has changed from "*"
to "x".

#### renderAll()
This will render a combined formatted string containing all dimensions, area and volume as an unordered list.

```
echo $page->fieldname->renderAll();
```
will output fe
```
Dimensions: 3 cm (L) * 4 cm (W) * 2 cm (H)
Area: 12 cm²
Volume: 24 cm²
```

You can get the same result with this call, which is equal to the _toString method():

```
echo $page->fieldname;
```

The renderAll() method supports the multiplication sign as parameter (like the renderDimensions() method)  inside the
parenthesis.

```
echo $page->fieldname->renderAll('x');
```

This replaces the default "*" with the "x" in this case.

```
Dimensions: 3 cm (L) x 4 cm (W) x 2 cm (H)
Area: 12 cm²
Volume: 24 cm²
```

## Find pages by using selectors

As written in the introduction, all the dimensions are fully searchable. Here are 3 examples on how to query.

The dimensions can be used in selectors like:

`$pages->find("fieldname.width=120");`

or

`$pages->find("fieldname.height>=100, fieldname.depth<120");`

or

`$pages->find("fieldname.volume>=1000");`

## Field configuration

As written above, there are several configuration settings, which can be changed on per field base.

![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/configuration.png?raw=true)

- Set type (2 or 3-dimensional)
- Set size unit as suffix after each inputfield (default is cm)
- Set max number of digits that can be entered in each field (default is 10)
- Set max number of decimals (default is 2)
- Show/hide a hint to the user how many digits/decimals are allowed

If the number of decimals will be changed, the database schema for each dimension column will also change (float/integer).

For example:
If the schema for each dimension field in the DB is f.e. "decimal(65,2)" and you will set the number of digits in the 
configuration to 12 and the number of decimals to 1, then the schema in the DB will also change to "decimal(12,1)"
after saving the inputfield.

If a number of 0 for decimals will be chosen, then the schema will automatically change from float to integer in the DB.

In addition, a small JavaScript prevents the user from entering more decimals into the inputs than set in the 
configuration of this fieldtype.
Fe. if you set the number of decimals to 2, then the user cannot enter more than 2 decimals in the inputfield

## Multi-language
This fieldtype supports multi-language and includes the German translation files by default.

## How to install

1. Download and place the module folder named "FieldtypeObjectDimensions" in:
/site/modules/

2. In the admin control panel, go to Modules. At the bottom of the
screen, click the "Check for New Modules" button.

3. Now scroll to the FieldtypeDimension module and click "Install". The required InputfieldObjectDimension will get
4. installed automatic.

4. Create a new Field with the new "ObjectDimension" Fieldtype.

## How to uninstall

Please note: During the installation, a fieldtype and an inputfield will be installed automatically with one click.
If you want to uninstall this module you have to uninstall the fieldtype and the inputfield separately.
