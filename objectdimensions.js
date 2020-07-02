// Remove everything after the second decimal and to remove everything exept numbers


function restrict(tis, digits) {
  var num = tis.value;
  console.log(num);
  if (isNaN(num)) {
    num.val(0);
  }

  if ((num.indexOf(".") > -1)  && (num.split('.')[1].length > digits)) {
    var newValue = num.substring(0, num.length - 1);
    tis.value = newValue;
  }
}
