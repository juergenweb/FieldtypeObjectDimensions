# ProcessWire-ObjectDimension-Fieldtype
An Inputfield and Fieldtype for ProcessWire CMS to enter dimensions (width, height, depth) of an object

This fieldtype was inspired by the amazing fieldtype "Fieldtype Dimensions" from SOMA ([https://modules.processwire.com/modules/fieldtype-dimension/](https://modules.processwire.com/modules/fieldtype-dimension/)). This Fieldtype was introduced in 2013 - so its the time to make a makeover of the whole thing.
The main differences are that you can use float numbers too and it adds also support for the computed calculation of the floor space of an object.
The code uses also some parts and ideas from the Fieldtype Decimals ([https://modules.processwire.com/modules/fieldtype-decimal/](https://modules.processwire.com/modules/fieldtype-decimal/)) - especially methods for altering the database schema.

## What it does

This fieldtype let's you define 3 dimensions width / height / depth as integer or float.

### Output the values in templates

There's a property for each dimension

```
echo $page->fieldname->width;
echo $page->fieldname->height;
echo $page->fieldname->depth;
```


There's also support for a computed value of the volume (W*H*D) and the space floor (W*D). This will get stored additionally
to the database and updated every time a dimension value changed. So it can also be used in selectors for querying.

You can get the computed values in templates by using

```
echo $page->fieldname->volume;
echo $page->fieldname->spacefloor;
```

### Use in selectors strings

The dimensions can be used in selectors like:

`$pages->find("dimension.width=120");`

or

`$pages->find("dimension.height>=100, dimension.depth<120");`

or

`$pages->find("dimension.volume>=1000");`

### Field Settings

There are several configuration options for this fieldtype in the backend. 

- set width attribute for the inputfield in px (default is 100px)
- set size unit as suffix after each inputfield (default is cm)
- set max number of digits that can be entered in each field (default is 10)
- set max number of decimals (default is 2)
- show/hide a hint to the user how decimals are allowed

Some of them can also be changed separately on per template base too.

If number of decimals will be changed, the database schema for each dimension column will also be changed.

For example:
If the schema for each dimension field in the DB is f.e. decimal(10,2) and you will set the number of digits in the configuration to 12 and the number of decimals to 1, then the schema in the DB will also change to decimal(12,1) after saving the inputfield.

If a number of 0 for decimals will be choosen, then the schema will automatically change from float to integer in the DB.

In addition a small JavaScript prevent the user from entering more decimals into the inputs than set in the configuration of the fieldtype.

## How to install

1. Download and place the module folder named "FieldtypeObjectDimensions" in:
/site/modules/

2. In the admin control panel, go to Modules. At the bottom of the
screen, click the "Check for New Modules" button.

3. Now scroll to the FieldtypeDimension module and click "Install". The required InputfieldObjectDimension will get installed automatic.

4. Create a new Field with the new "ObjectDimension" Fieldtype.

