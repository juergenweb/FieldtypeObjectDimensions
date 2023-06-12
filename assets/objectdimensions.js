/*
Javascript file for the backend

Created by Jürgen K.
https://github.com/juergenweb
File name: objectdimensions.js
Created: 02.02.2022
*/

// Remove everything after the second decimal and to remove everything except numbers

function restrict(tis, digits) {
  let num = tis.value;
  if (isNaN(num)) {
    num.val(0);
  }

  if ((num.indexOf(".") > -1)  && (num.split('.')[1].length > digits)) {
    tis.value = num.substring(0, num.length - 1);
  }
}
