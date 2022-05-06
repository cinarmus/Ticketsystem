 $("#form_kunde").validate({
    rules: {
        Kundennummer: {
            required: true,
            number:  true,
            minlength: 6,
            maxlength: 8
        },
        Vorname: {
            required: true           
        },
        Name: {
            required: true           
        },
        Telefon: {
            required: true           
        },
        email: {
            required: true,
            email: true
            
        },
        Adresse_PLZ: {
            number: true,
            minlength: 5,
            maxlength: 5
        }
    },
    messages: {
        Kundennummer: {
            required: "Die Kundennumnmer ist ein Pflichtfeld",
            number:"Bei der Kundenummer handelt es sich um eine Zahl", 
         },     
        email: {
            required: "Plichtfeld",
            email: "Bitte eine gültige E-Mailadresse eintragen"
        },
        Vorname: {
            required: "Bitte geben Sie einen Vornamen ein",
        },
        Name: {
            required: "Bitte geben Sie einen Nachnamen ein",
        },
        Telefon: {
            required: "Bitte geben Sie eine gültige Telefonnummer ein"
        },
        Adresse_PLZ: {
            number: "Bitte geben Sie eine gültige Postleitzahl ein",
            minlength: "Die Postleitzahl besteht aus 5 Stellen",
            maxlength: "Die Postleitzahl besteht aus 5 Stellen"
            
        }
    }
   
});