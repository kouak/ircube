/* Validateur de formulaire */
var formValidator = {
	/* Liste des validations à effectuer */
	validations : new Array ,
	
	/* Ajoute une nouvelle validation :
		field_id : id du champ à valider
		conditions : conditions de la validation
		message : paramètres du message */
	addValidation : function(field_id, conditions, message) {
		this.validations.push(new Validation(field_id, conditions, message));
	},
	
	/* Récapitulatif des validators */
	show : function() {
		for(i=0;i<this.validations.length;i++) {
			alert(this.validations[i].field_id) ;
		}
	},
	
	/* Execution de la validation */
	validate : function() {
		this.validated = true ;
		for(i=0;i<this.validations.length;i++) {
			/* Vérification des conditions */
			var all_validated = true ;
			/* Champ obligatoire */
			if (this.validations[i].conditions.requested) {
				if (!document.getElementById(this.validations[i].field_id).value) {
					all_validated = false ;	
				}
			}
			/* Longueur maximum */
			if (this.validations[i].conditions.maxlength) {
				if (document.getElementById(this.validations[i].field_id).value.length > this.validations[i].conditions.maxlength) {
					all_validated = false ;	
				}
			}
			/* Longueur minimum */
			if (this.validations[i].conditions.minlength) {
				if (document.getElementById(this.validations[i].field_id).value.length < this.validations[i].conditions.maxlength) {
					all_validated = false ;	
				}
			}
			
			/* Est numérique */
			if (this.validations[i].conditions.numeric) {
				if (!document.getElementById(this.validations[i].field_id).value.match(/^[0-9]*$/)) {
					all_validated = false ;
				}
			}	
							
			/* Toutes les conditions sont-elles ok ? */
			if (!all_validated) {
				this.sendMessage(this.validations[i].message) ;
				this.validated = false ;
			}	
		}
		
		return this.validated ;
	},
	
	sendMessage : function(message) {
		if (!message.message_type) { message.message_type = "innerHTML" ; }
		switch(message.message_type) {
			case "alert" : alert(message.message_content) ; break ;
			default : document.getElementById(message.message_id).innerHTML = message.message_content ; break ;
		}		
	}			
}	

/* Objet Validation */		
function Validation(field_id, conditions, message) {
	this.field_id = field_id;
	this.conditions = conditions ;
	this.message = message ;
}
		
		
	 