# ProcessWire-ObjectDimension-Fieldtype
An inputfield and fieldtype for the ProcessWire CMS to enter dimensions (width, height and depth) of an object.

This fieldtype was inspired by the amazing fieldtype "Fieldtype Dimensions" from SOMA ([https://modules.processwire.com/modules/fieldtype-dimension/](https://modules.processwire.com/modules/fieldtype-dimension/)). This fieldtype was introduced in 2013 - so its time for a relaunch.
This new fieldtype offers more possibilities than the old one from SOMA.

**The main differences**<br />
You can select if 2 dimensions (width, height) or 3 dimension (width, height and depth) should be displayed. 2 dimensions can be used for photos, wallpapers and so on. 3 dimensions for other objects.
You can enter the dimensions as float numbers and as integers and not only as integers.

The code uses also some parts and ideas from the Fieldtype Decimals ([https://modules.processwire.com/modules/fieldtype-decimal/](https://modules.processwire.com/modules/fieldtype-decimal/)) - especially methods for altering the database schema.

## What it does

This inputfield/fieldtype let you enter 3 dimensions (width/height/depth) of an object (fe a product).
You can select if you want to display inputs for 2 or 3 dimensions.

### 2 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/images/blob/master/objectdimensions1.png?raw=true)

### 3 dimensions inputfield:
![alt text](https://github.com/juergenweb/ProcessWire-ObjectDimension-Fieldtype/blob/master/objectdimensions2.png?raw=true)

### Output the values in templates

There's a property for each dimension

```
echo $page->fieldname->width;
echo $page->fieldname->height;
echo $page->fieldname->depth;
```

There's also support for a computed value of the volume (WHD) and the area (WH). This will get stored additionally
to the database and updated every time a dimension value changes. It can also be used in selectors for querying  (fe list all products where the volume is larger than....)

You can get the computed values in templates by using

```
echo $page->fieldname->volume;
echo $page->fieldname->area;
```
For outputting the selected unit (fe. cm) on the frontend you can use

```
echo $page->fieldname->unit;
```

There are also several other rendering methods that can be used on the frontend

```
echo $page->fieldname->renderDimensions();
```
will produce fe the following output:

```
0.12cm * 0.35cm * 3.75cm
```

For more customization you can enter 2 additional parameters.
The first parameter is for the multiplication sign (default is "*"), the second one for displaying the unit (default is true).

```
echo $page->fieldname->renderDimensions(' x ', false);
```
will produce fe the following output:

```
0.12 x 0.35 x 3.75
```

Render method for the volume (value including unit):

```
echo $page->fieldname->renderVolume();
```
will output fe
```
12,75cm³
```

Render method for the area (value including unit):

```
echo $page->fieldname->renderArea();
```

This will output fe:
```
8,30cm²
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
