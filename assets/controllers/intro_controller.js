import {Controller} from '@hotwired/stimulus';
import $ from "jquery";
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

	connect() {
		introJS()
		    .onbeforeexit(function () {
		    	confirm("Vous me quittez déjà ?");
				$.post(Routing.generate('user_intro_menu'));
				return
		    })
		    .setOptions({
		        prevLabel: 'Précédent',
		        nextLabel: 'Suivant',
		        doneLabel: 'Terminer',
		        disableInteraction: true,
		        showProgress: true,
		        steps: [
		            {
		                title: 'Salut et 👋 Bienvenu',
		                intro: `Vous êtes sur votre page de profil nous allons faire un tour de présentation des différents menus`,
		                element: document.querySelector('#features'),
		            },
		            {
		                element: document.querySelector('#pills-info-tab'),
		                intro: `Tu trouveras tes <b>informations personnelles</b> ici`
		            },
		            {
		                element: document.querySelector('#pills-profile-tab'),
		                intro: 'Visualise tes <b>photos et choisi celle que tu veux</b> voir en principale'
		            },
		            {
		                element: document.querySelector('#pills-contact-tab'),
		                intro: 'Tu peux choisir tes passions ici, c\'est le <b>plus</b> important'
		            },
					{
						element: document.querySelector('#pills-preferences-tab'),
						intro: 'Règle tes <b>préférences de recherche</b> afin de mieux affiner les resultats'
					},
					{
						element: document.querySelector('#pills-options-tab'),
						intro: 'Si tu veux configurer ton <b>expérience</b> fait un tour par là'
					},
					{
						element: document.querySelector('#match'),
						intro: 'C\'est <b>le coeur</b> de ne notre application.' +
							'<br> Tu y passera la majeure partie de ton temps <br> Afin de trouver l\'âme sœur'
					},
					{
						element: document.querySelector('#match-secret'),
						intro: 'Si tu es abonnés alors tu aura la possibilité de <b>voir les membres avec qui tu match(e)s</b>'
					},
					{
						element: document.querySelector('#chat'),
						intro: 'Lorsque tu auras des matchs alors tu pourras <b>déployer tout ton charme</b>'
					},
					{
						element: document.querySelector('#compte'),
						intro: 'Ici tu as accès à ton compte et tout <b>les paramètres</b> afin de trouver la bonne personne'
					},
					{
						title: 'Merci et @ bientôt 👋',
						intro: `Nous espérons que vous apprécierez votre expérience`,
						element: document.querySelector('#features'),
					},
		        ]
		    })
			.start()
	}
}
