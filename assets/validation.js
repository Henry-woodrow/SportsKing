const form = document.querySelector('form');
const fname = document.getElementById('fname');
const lname = document.getElementById('lname');
const contactNum = document.getElementById('contact_number');
const email = document.getElementById('email_address');
const address = document.getElementById('address');
const city = document.getElementById('city');
const postcode = document.getElementById('postcode');
const country = document.getElementsByName('country')[0];
const password = document.getElementById('password');
const reEnterPassword = document.getElementById('re-enter_password');

form.addEventListener('submit', (e) => {
  let isValid = true;

  // validate first name
  if (fname.value === '') {
    document.getElementById('error_fname').innerHTML = 'Please enter your first name.';
    document.getElementById('error_fname').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('error_fname').style.display = 'none';
  }

  // validate last name
  if (lname.value === '') {
    document.getElementById('error_lname').innerHTML = 'Please enter your last name.';
    document.getElementById('error_lname').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('error_lname').style.display = 'none';
  }

  // validate contact number
  if (contactNum.value === '') {
    document.getElementById('error_contact_num1').innerHTML = 'Please enter your contact number.';
    document.getElementById('error_contact_num1').style.display = 'block';
    isValid = false;
  } else if (!/^\d{10}$/.test(contactNum.value)) {
    document.getElementById('error_contact_num2').innerHTML = 'Please enter a valid 10-digit contact number.';
    document.getElementById('error_contact_num2').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('error_contact_num1').style.display = 'none';
    document.getElementById('error_contact_num2').style.display = 'none';
  }

  // validate email
  if (email.value === '') {
    document.getElementById('error_email1').innerHTML = 'Please enter your email address.';
    document.getElementById('error_email1').style.display = 'block';
    isValid = false;
  } else if (!/\S+@\S+\.\S+/.test(email.value)) {
    document.getElementById('error_email2').innerHTML = 'Please enter a valid email address.';
    document.getElementById('error_email2').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('error_email1').style.display = 'none';
    document.getElementById('error_email2').style.display = 'none';
  }

  // validate address
  if (address.value === '') {
    document.getElementById('error_address').innerHTML = 'Please enter your address.';
    document.getElementById('error_address').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('error_address').style.display = 'none';
  }

  // validate city
  if (city.value === '') {
    document.getElementById('error_city').innerHTML = 'Please enter your city.';
    document.getElementById('error_city').style.display = 'block';
    isValid = false;
  } else {
    document.getElementById('error_city').style.display = 'none';
  }
});