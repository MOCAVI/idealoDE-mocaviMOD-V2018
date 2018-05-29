
# User Guide für das Elastic Export idealo.de Plugin

<div class="container-toc"></div>

## 1 Bei idealo.de registrieren

idealo.de ist ein deutsches Preisportal und bietet Preisvergleiche mit Angeboten und Preisen, Testberichten sowie Preisbenachrichtigungen und Produktvergleichen. Weitere Informationen zu idealo.de finden Sie auf der Handbuchseite [idealo Direktkauf einrichten](https://www.plentymarkets.eu/handbuch/multi-channel/idealo/). Um das Plugin für idealo.de einzurichten, registrieren Sie sich zunächst als Händler.

## 2 Das Format IdealoDE-Plugin in plentymarkets einrichten

Mit der Installation dieses Plugins erhalten Sie das Exportformat **IdealoDE-Plugin**, mit dem Sie Daten über den elastischen Export zu idealo.de übertragen. Um dieses Format für den elastischen Export nutzen zu können, installieren Sie zunächst das Plugin **Elastic Export** aus dem plentyMarketplace, wenn noch nicht geschehen.

Sobald beide Plugins in Ihrem System installiert sind, kann das Exportformat **IdealoDE-Plugin** erstellt werden. Mehr Informationen finden Sie auch auf der Handbuchseite [Daten exportieren](https://knowledge.plentymarkets.com/basics/datenaustausch/daten-exportieren#60).

Neues Exportformat erstellen:

1. Öffnen Sie das Menü **Daten » Elastischer Export**.
2. Klicken Sie auf **Neuer Export**.
3. Nehmen Sie die Einstellungen vor. Beachten Sie dazu die Erläuterungen in Tabelle 1.
4. **Speichern** Sie die Einstellungen.
→ Eine ID für das Exportformat **IdealoDE-Plugin** wird vergeben und das Exportformat erscheint in der Übersicht **Exporte**.

In der folgenden Tabelle finden Sie Hinweise zu den einzelnen Formateinstellungen und empfohlenen Artikelfiltern für das Format **IdealoDE-Plugin**.

| **Einstellung**                      | **Erläuterung** |
| :---                                 | :--- |
| **Einstellungen**                    |
| **Name**                             | Name eingeben. Unter diesem Namen erscheint das Exportformat in der Übersicht im Tab **Exporte**. |
| **Typ**                              | Typ **Artikel** aus der Dropdown-Liste wählen. |
| **Format**                           | **IdealoDE-Plugin** wählen. |
| **Limit**                            | Zahl eingeben. Wenn mehr als 9999 Datensätze an die Preissuchmaschine übertragen werden sollen, wird die Ausgabedatei wird für 24 Stunden nicht noch einmal neu generiert, um Ressourcen zu sparen. Wenn mehr mehr als 9999 Datensätze benötigt werden, muss die Option **Cache-Datei generieren** aktiv sein. |
| **Cache-Datei generieren**           | Häkchen setzen, wenn mehr als 9999 Datensätze an die Preissuchmaschine übertragen werden sollen. Um eine optimale Performance des elastischen Exports zu gewährleisten, darf diese Option bei maximal 20 Exportformaten aktiv sein. |
| **Bereitstellung**                   | **URL** wählen. |
| **Dateiname**                        | Der Dateiname muss auf **.csv** oder **.txt** enden, damit idealo die Datei erfolgreich importieren kann. |
| **Token, URL**                       | Wenn unter **Bereitstellung** die Option **URL** gewählt wurde, auf **Token generieren** klicken. Der Token wird dann automatisch eingetragen. Die URL wird automatisch eingetragen, wenn unter **Token** der Token generiert wurde. |
| **Artikelfilter**                    |
| **Artikelfilter hinzufügen**         | Artikelfilter aus der Dropdown-Liste wählen und auf **Hinzufügen** klicken. Standardmäßig sind keine Filter voreingestellt. Es ist möglich, alle Artikelfilter aus der Dropdown-Liste nacheinander hinzuzufügen.<br/> **Varianten** = **Alle übertragen** oder **Nur Hauptvarianten übertragen** wählen.<br/> **Märkte** = **idealo** wählen.<br/> **Währung** = Währung wählen.<br/> **Kategorie** = Aktivieren, damit der Artikel mit Kategorieverknüpfung übertragen wird. Es werden nur Artikel, die dieser Kategorie zugehören, übertragen.<br/> **Bild** = Aktivieren, damit der Artikel mit Bild übertragen wird. Es werden nur Artikel mit Bildern übertragen.<br/> **Mandant** = Mandant wählen.<br/> **Bestand** = Wählen, welche Bestände exportiert werden sollen.<br/> **Markierung 1 - 2** = Markierung wählen.<br/> **Hersteller** = Einen, mehrere oder **ALLE** Hersteller wählen.<br/> **Aktiv** = Nur aktive Varianten werden übertragen. |
| **Formateinstellungen**              |
| **Produkt-URL**                      | Wählen, ob die URL des Artikels oder der Variante an das Preisportal übertragen wird. Varianten URLs können nur in Kombination mit dem Ceres Webshop übertragen werden. |
| **Mandant**                          | Mandant wählen. Diese Einstellung wird für den URL-Aufbau verwendet. |
| **URL-Parameter**                    | Suffix für die Produkt-URL eingeben, wenn dies für den Export erforderlich ist. Die Produkt-URL wird dann um die eingegebene Zeichenkette erweitert, wenn weiter oben die Option **übertragen** für die Produkt-URL aktiviert wurde. |
| **Auftragsherkunft**                 | Die Auftragsherkunft **Idealo** wählen. |
| **Marktplatzkonto**                  | Marktplatzkonto aus der Dropdown-Liste wählen. Die Produkt-URL wird um die gewählte Auftragsherkunft erweitert, damit die Verkäufe später analysiert werden können. |
| **Sprache**                          | Sprache aus der Dropdown-Liste wählen. |
| **Artikelname**                      | **Name 1**, **Name 2** oder **Name 3** wählen. Die Namen sind im Tab **Texte** eines Artikels gespeichert. Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn die Preissuchmaschine eine Begrenzung der Länge des Artikelnamen beim Export vorgibt. |
| **Vorschautext**                     | Wählen, ob und welcher Text als Vorschautext übertragen werden soll.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn die Preissuchmaschine eine Begrenzung der Länge des Vorschautextes beim Export vorgibt.<br/> Option **HTML-Tags entfernen** aktivieren, damit die HTML-Tags beim Export entfernt werden.<br/> Im Feld **Erlaubte HTML-Tags, kommagetrennt (def. Text)** optional die HTML-Tags eingeben, die beim Export erlaubt sind. Wenn mehrere Tags eingegeben werden, mit Komma trennen. |
| **Beschreibung**                     | Wählen, welcher Text als Beschreibungstext übertragen werden soll.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn die Preissuchmaschine eine Begrenzung der Länge der Beschreibung beim Export vorgibt.<br/> Option **HTML-Tags entfernen** aktivieren, damit die HTML-Tags beim Export entfernt werden.<br/> Im Feld **Erlaubte HTML-Tags, kommagetrennt (def. Text)** optional die HTML-Tags eingeben, die beim Export erlaubt sind. Wenn mehrere Tags eingegeben werden, mit Komma trennen. |
| **Zielland**                         | Zielland aus der Dropdown-Liste wählen. |
| **Barcode**                          | ASIN, ISBN oder eine EAN aus der Dropdown-Liste wählen. Der gewählte Barcode muss mit der oben gewählten Auftragsherkunft verknüpft sein. Andernfalls wird der Barcode nicht exportiert. |
| **Bild**                             | **Position 0** oder **Erstes Bild** wählen, um dieses Bild zu exportieren.<br/> **Position 0** = Ein Bild mit der Position 0 wird übertragen.<br/> **Erstes Bild** = Das erste Bild wird übertragen. |
| **Bildposition des Energieetiketts** | Position des Energieetikettes eintragen. Alle Bilder die als Energieetikette übertragen werden sollen, müssen diese Position haben. |
| **Bestandspuffer**                   | Der Bestandspuffer für Varianten mit der Beschränkung auf den Netto-Warenbestand. |
| **Bestand für Varianten ohne Bestandsbeschräkung** | Der Bestand für Varianten ohne Bestandsbeschränkung. |
| **Bestand für Varianten ohne Bestandsführung** | Der Bestand für Varianten ohne Bestandsführung. |
| **Verkaufspreis** | Brutto- oder Nettopreis aus der Dropdown-Liste wählen. |
| **Angebotspreis** | Diese Option ist für dieses Format nicht relevant. |
| **UVP** | Aktivieren, um den UVP zu übertragen. |
| **Versandkosten** | Im Gegensatz zu anderen Formaten spielt hier die Auswahl einer Zahlungsart keine Rolle. Es werden alle Zahlungsarten der gewählten Konfiguration exportiert.<br/> Wenn keine Konfiguration gewählt wurde, werden alle Konfigurationen und alle Zahlungsarten exportiert.<br/> Wenn **Pauschale Versandkosten übertragen** gewählt wurde, wird nur Vorkasse als Zahlungsart übermittelt. |
| **MwSt.Hinweis** | Diese Option ist für dieses Format nicht relevant. |
| **Artikelverfügbarkeit** | Option **überschreiben** aktivieren und in die Felder **1** bis **10**, die die ID der Verfügbarkeit darstellen, Artikelverfügbarkeiten eintragen. Somit werden die Artikelverfügbarkeiten, die im Menü **System » Artikel » Verfügbarkeit** eingestellt wurden, überschrieben. |

## 3 Verfügbare Spalten der Exportdatei

| **Spaltenbezeichnung**  | **Erläuterung** |
| :---                    | :--- |
| **article_id**          | **Pflichtfeld**<br/> Die SKU des Artikels. Bei Artikeln, die für idealo Direktkauf freigegeben wurden, wird hier eine SKU für idealo Direktkauf ausgegeben. |
| **deeplink**            | **Pflichtfeld**<br/> Der URL-Pfad des Artikels abhängig vom gewählten Mandanten in den Formateinstellungen.|
| **name**                | **Pflichtfeld**<br/> Entsprechend der Formateinstellung Artikelname.|
| **short_description**   | Entsprechend der Formateinstellung Vorschautext. |
| **description**         | **Beschränkung**: max. 1000 Zeichen<br/> Entsprechend der Formateinstellung Beschreibung. |
| **article_no**          | Die Variantennr. unter **Artikel » Artikel bearbeiten » Artikel öffnen » Variante öffnen » Einstellungen » Grundeinstellungen**. |
| **producer**            | Der Name des Herstellers des Artikels. Der Externe Name unter **Einstellungen » Artikel » Hersteller** wird bevorzugt, wenn vorhanden. |
| **model**               | Das Modell unter **Artikel » Artikel bearbeiten » Artikel öffnen » Variante öffnen » Einstellungen » Grundeinstellungen**. |
| **availability**        | **Pflichtfeld**<br/> Der Name der Artikelverfügbarkeit unter **Einstellungen » Artikel » Artikelverfügbarkeit** oder die Übersetzung gemäß der Formateinstellung **Artikelverfügbarkeit überschreiben**. |
| **ean**                 | Entsprechend der Formateinstellung **Barcode**. |
| **isbn**                | Entsprechend der Formateinstellung **Barcode**. |
| **fedas**               | Der Amazon-Produkttyp unter **Artikel » Artikel bearbeiten » Artikel öffnen » Multi-Channel » Amazon**. |
| **warranty**            | Aktuell nicht gepflegt. |
| **price**               | **Pflichtfeld**<br/> Der Verkaufspreis der Variante. |
| **price_old**           | Der Verkaufspreis vom Typ UVP der Variante, wenn in den Formateinstellungen aktiviert. |
| **weight**              | Gewicht brutto in Gramm unter **Artikel » Artikel bearbeiten » Artikel öffnen » Variante öffnen » Einstellungen » Maße**. |
| **category1-6**         | Der Name der Kategorieebene des Kategoriepfads der Standard-Kategorie für den in den Formateinstellungen definierten Mandanten. |
| **category_concat**     | Kategoriepfad der Standard-Kategorie für den in den Formateinstellungen definierten Mandanten. |
| **image_url_preview**   | URL zu einer für die Vorschau skalierten Version des Bildes gemäß der Formateinstellung **Bild**. |
| **image_url**           | **Pflichtfeld**<br/> URL zu dem Bild gemäß der Formateinstellung **Bild**. |
| **base_price**          | Die Grundpreisinformation im Format "Preis / Einheit". (Beispiel: 10,00 EUR / Kilogramm) |
| **free_text_field**     | Der Wert eines Merkmals vom Typ Text oder Auswahl mit der Verknüpfung zu idealo. |
| **checkoutApproved**    | Wird true gesetzt, wenn entweder die Auftragsherkunft idealo Direktkauf unter **Artikel » Artikel bearbeiten » Artikel öffnen » Variante öffnen » Verfügbarkeit » Märkte** aktiviert wurde oder ein Merkmal vom Typ Kein und der Verknüpfung zum idealo Direktkauf-Merkmal checkoutApproved gesetzt wurde. |
| **itemsInStock**        | **Voraussetzung**: checkoutApproved ist true.<br/> Der Nettowarenbestand der Variante. Bei Artikeln, die nicht auf den Nettowarenbestand beschränkt sind, wird 999 übertragen. |
| **fulfillmentType**     | **Voraussetzung**: checkoutApproved ist true.<br/> Merkmal vom Typ Kein und der Verknüpfung zum idealo Direktkauf-Merkmal FulfillmentType » Spedition oder FulfillmentType » Paketdienst. |
| **twoManHandlingPrice** | **Voraussetzung**: checkoutApproved ist true und fulfillmentType ist Spedition.<br/> Merkmal vom Typ Text, Auswahl oder Kommazahl und der Verknüpfung zum idealo Direktkauf-Merkmal twoManHandlingPrice. |
| **disposalPrice**       | **Voraussetzung**: checkoutApproved ist true und fulfillmentType ist Spedition.<br/> Merkmal vom Typ Text, Auswahl oder Kommazahl und der Verknüpfung zum idealo Direktkauf-Merkmal disposalPrice. |
| **Zahlungsarten**       | **Pflichtfeld**: (Mindestens eine Zahlungsart)<br/> Es werden die Zahlungsarten gemäß der Formateinstellung **Versandkosten** in einer eigenen Spalte übermittelt. |

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-idealo-de/blob/master/LICENSE.md).
