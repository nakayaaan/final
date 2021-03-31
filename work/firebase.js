'use strict';

const config = {
    apiKey: "AIzaSyB3hV0zOnBvj024O6usnBOd-2TpwVoji6o",
    authDomain: "product-6a6fd.firebaseapp.com",
    projectId: "product-6a6fd",
    storageBucket: "product-6a6fd.appspot.com",
    messagingSenderId: "51289601880",
    appId: "1:51289601880:web:9d0cb134b48ac8da06972d"
  };

  const db = firebase.firestore();
db.settings({
  timestampsInSnapshots: true
});
const collection = db.collection('messages');

collection.add({
  message: 'test'
})
.then(doc => {
  console.log(`${doc.id} added!`);
})
.catch(error => {
  console.log(error);
});