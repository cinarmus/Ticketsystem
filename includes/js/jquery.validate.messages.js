jQuery.extend(jQuery.validator.messages, {
    required: "*Pflichtfeld",
    remote: "Please fix this field.",
    email: "Bitte eine gültige E-Mailadresse angeben",
    url: "Bitte eine gültige Webadresse eingeben",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Bitte eine Zahl eingeben",
    digits: "Bitte nur Ziffern eingeben",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Beide Felder müssen übereinstimmen",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Maximal {0} Zeichen erlaubt."),
    minlength: jQuery.validator.format("Mindestens {0} Zeichen nötig."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Der Wert darf maximal {0} sein."),
    min: jQuery.validator.format("Der Wert muss mindestens {0} betragen.")
  
});
