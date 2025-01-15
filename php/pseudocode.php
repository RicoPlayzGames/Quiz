<!-- 
// Deze code zorgt voor een startpagina en inlogfunctionaliteit
#1 DISPLAY een welkomsscherm met twee opties:
   - "Start quiz" knop
   - "Inloggen" knop

#2 IF gebruiker klikt op "Inloggen":
   DISPLAY een inlogformulier:
      - INPUT: Gebruikersnaam
      - INPUT: Wachtwoord
   #3 VALIDATE inloggegevens:
      - CONNECT met de database
      - CHECK of gebruikersnaam en wachtwoord overeenkomen met opgeslagen gegevens
      - IF correct:
          DISPLAY: "Welkom [gebruikersnaam]"
      - ELSE:
          DISPLAY: "Ongeldige inloggegevens, probeer opnieuw"
          
#4 IF gebruiker klikt op "Start quiz" zonder in te loggen:
   DISPLAY een waarschuwing: "Je moet eerst inloggen om de quiz te starten."

#5 AFTER succesvolle inlog:
   ENABLE toegang tot de quizpagina
 

//Deze code zorgt ervoor dat je quiz start als je op de button clickt
#1 INPUT gebruiker klikt op de start knop
#2 GET button ID en verberg de start knop
#3 INITIALISE `huidigeVraag = 0`
#4 DISPLAY de eerste vraag (vragen[huidigeVraag]) en bijbehorende antwoorden


//Deze code zet een timer voor de duur van elke vraag
#1 PROCESS SetTimer
#2 WHILE Timer > 0 
#3 DISPLAY huidige timerwaarde
#4 REPEAT elke seconde DECREMENT Timer -1
#5 WHEN Timer = 0
#6 PROCESS checkantwoord()

//Deze code controleerd of het antwoord juist is.
#1 INPUT de gebruiker vult 1 van de 4 antwoorden in.
#2 PROCESS checkantwoord()
#2 DETERMINE check of het antwoord overeenkomt met het juiste antwoord.
#3 IF antwoord is juist 
   DISPLAY "Juist"
#4 ELSE 
   DISPLAY "Fout"
#5 CHECK of er nog meer vragen over zijn:
   IF er zijn nog vragen:
      LOAD de volgende vraag
      RESET de timer
   ELSE
      DISPLAY "Quiz afgelopen" en toon eindscore.


//Deze code zorgt ervoor dat je naar de volgende vraag gaat als de timer is afgelopen
#1 PROCESS  volgendevraag()
#2 INCREMENT huidigevraag met 1
#3 IF [huidigevraag]<aantalvragen  
    toon volgendevraag()
    ELSE 
    DISPLAY "de quiz is afgelopen" 
    

// Deze code zorgt ervoor dat het resultaat aan het einde van de quiz wordt weergegeven
#1 DETERMINE totale score
   CALCULATE: juiste antwoorden / totaal aantal vragen * 100 = percentage
#2 DISPLAY: "Je score is: [score] / [totaal aantal vragen] ([percentage]%)"
#3 IF percentage >= 80%
   DISPLAY: "Gefeliciteerd, je hebt de quiz gehaald!"
#4 ELSE
   DISPLAY: "Helaas, je hebt de quiz niet gehaald. Probeer het opnieuw!"
#5 Sla de resultaten op in de database (zie database-interacties hieronder)

// Deze code regelt eenvoudige interacties met de database
#1 CONNECT met de database 
#2 VOOR inlogfunctionaliteit:
   - TABLE: `gebruikers`
     COLUMNS: `id`, `gebruikersnaam`, `wachtwoord_hash`
   - QUERY: SELECT * FROM `gebruikers` WHERE `gebruikersnaam` = [input] AND `wachtwoord_hash` = [input]

#3 VOOR opslaan van quizresultaten:
   - TABLE: `resultaten`
     COLUMNS: `id`, `gebruiker_id`, `quiz_id`, `score`, `percentage`, `datum`
   - QUERY: INSERT INTO `resultaten` (`gebruiker_id`, `quiz_id`, `score`, `percentage`, `datum`)
            VALUES ([gebruiker_id], [quiz_id], [score], [percentage], CURRENT_DATE)

#4 VOOR ophalen van feedback na de quiz (optioneel):
   - TABLE: `feedback`
     COLUMNS: `vraag_id`, `feedback_tekst`
   - QUERY: SELECT `feedback_tekst` FROM `feedback` WHERE `vraag_id` = [vraag_id]
    
    -->
