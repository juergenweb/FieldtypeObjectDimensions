# ProcessWire-ObjectDimension-Fieldtype
An inputfield and fieldtype for the ProcessWire CMS to enter dimensions (length, width and height) of an object.

This fieldtype was inspired by the amazing fieldtype "Fieldtype Dimensions" from SOMA ([https://modules.processwire.com/modules/fieldtype-dimension/](https://modules.processwire.com/modules/fieldtype-dimension/)). This fieldtype was introduced in 2013 - so its time for a relaunch.
This new fieldtype offers more possibilities than the old one from SOMA.

**The main differences**<br />
You can select if 2 dimensions (length and width) or 3 dimension (length, width and height) should be displayed. 2 dimensions can be used for photos, wallpapers and so on. 3 dimensions for other objects.
You can enter the dimension values as float numbers or as integers.

The code uses also some parts and ideas from the Fieldtype Decimals ([https://modules.processwire.com/modules/fieldtype-decimal/](https://modules.processwire.com/modules/fieldtype-decimal/)) - especially methods for altering the database schema.

## What it does

This inputfield/fieldtype let you enter 2 or 3 dimension values of an object (fe a product) and calculates and stores the volume and the area.
All the values are fully searchable by its values, so if you create a filter function you can grab all products with fullfill certain dimensions (fe show me all products where the length is lower than 100 cm and the width is lower than 30 cm).

### 2 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/objectdimensions1.png?raw=true)

### 3 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/images/objectdimensions2.png?raw=true)

### Raw output of the values in templates

There's a property for each dimension

```
echo $page->fieldname->lenght;
echo $page->fieldname->width;
echo $page->fieldname->height;
```
This values are the raw values, which means this are the values as they come from the database (only float or integer values). They do not contain the unit.

There's also support for a computed value of the volume (LWH) and the area (LW). This will get stored additionally
to the database and updated every time a dimension value changes. It can also be used in selectors for querying  (fe list all products where the volume is larger than....)

You can get the computed values in templates by using

```
echo $page->fieldname->volume;
echo $page->fieldname->area;
```
This values are also raw values which means they do not have a unit and are of type integer or float.
For outputting the selected unit (fe. cm) on the frontend you can use

```
echo $page->fieldname->unit;
```
This outputs the unit as a string (fe cm).

### Formatted output of the values in templates

If you want to use formatted values (values including the unit and optionally the label), you can use the following render methods.

#### renderDimensions()
This will render a formatted string containing all dimensions.

```
echo $page->fieldname->renderDimensions(); 
```
will produce fe the following output:

```
0.12cm (L) * 0.35cm (W) * 3.75cm (H)
```

For more customization you can enter 2 additional parameters inside the brackets.

- The first one for displaying the label (default is false).
- The second parameter is for the multiplication sign (default is "*"), 

```
echo $page->fieldname->renderDimensions(true, 'x');
```
will produce fe the following output:

```
Dimensions: 0.12cm (L) x 0.35cm (W) x 3.75cm (H)
```

#### renderVolume()
Render method for the volume (value including unit):

```
echo $page->fieldname->renderVolume();
```
will output fe
```
12,75cm³
```

Entering true as parameter outputs the label too.

```
echo $page->fieldname->renderVolume(true);
```
will output fe
```
Volume: 12,75cm³
```

#### renderArea()
Render method for the area (value including unit):

```
echo $page->fieldname->renderArea();
```

This will output fe:
```
8,30cm²
```

Entering true as parameter outputs the label too.

```
echo $page->fieldname->renderArea(true);
```
will output fe
```
Area: 12,75cm³
```

#### renderAllDimensions()
This will render a combined formatted string containing all dimensions, area and volume as an unordered list.

```
echo $page->fieldname->renderAllDimensions(); 
```
will produce fe the following output:

```
0.12cm (L) * 0.35cm (W) * 3.75cm (H)
8,30cm²
12,75cm³
```

For more customization you can enter 2 additional parameters inside the brackets.

- The first one for displaying the label (default is false).
- The second parameter is for the multiplication sign (default is "*"), 

```
echo $page->fieldname->renderDimensions(true, 'x');
```
will produce fe the following output:

```
Dimensions: 0.12cm (L) * 0.35cm (W) * 3.75cm (H)
Area: 8,30cm²
Volume: 12,75cm³
```

### Use in selectors strings

The dimensions can be used in selectors like:

`$pages->find("fieldname.width=120");`

or

`$pages->find("fieldname.height>=100, fieldname.depth<120");`

or

`$pages->find("fieldname.volume>=1000");`

### Field Settings

There are several configuration options for this fieldtype in the backend.

- set type (2 or 3 dimensional)
- set width attribute for the inputfield in px (default is 100px)
- set size unit as suffix after each inputfield (default is cm)
- set max number of digits that can be entered in each field (default is 10)
- set max number of decimals (default is 2)
- show/hide a hint to the user how much digits/decimals are allowed

Some of the configurations settings can also be changed separately on per template base too.

If number of decimals will be changed, the database schema for each dimension column will also change.

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
