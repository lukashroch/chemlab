export default {
  cs: {
    admin: {
      title: 'Administrace',
      index: 'Administrace'
    },
    audits: {
      title: 'Audit',
      index: 'Audits',
      show: 'Audit detail',
      new: 'New audit',
      create: 'Add audit',
      edit: 'Edit audit',
      delete: 'Delete audit',
      deleted: 'Deleted ({id})',
      type: 'Record type',
      name: 'Name/ID',
      event: 'Event'
    },
    auth: {
      failed: 'Tyto přihlašovací údaje neodpovídají žadnému záznamu.',
      throttle: 'Příliš mnoho pokusů o přihlášení. Zkuste to prosím znovu za {seconds} vteřin.',
      verify: {
        _: 'Ověření emailové adresy',
        confirm:
          'Než budete pokračovat, prosím zkontrolujte Váš email a potvrďte Vaši emailovou adresu.',
        resent:
          'Nový odkaz pro ověření byl odeslán na vaši emailovou adresu (nezapomeňte zkontrolovat SPAM složku).',
        resend_1:
          'Pokud jste neobdrželi žádný email během 30-60 minut po registraci, můžete si zde vyžádat další.',
        resend_2: 'Poslat nový ověřovací email'
      }
    },
    backups: {
      title: 'Záloha databáze',
      index: 'Záloha databáze',
      show: 'Stáhnout zálohu',
      new: 'Nová záloha',
      create: 'Vytvořit zálohu',
      delete: 'Odstranit zálohu',
      none: 'Žádná záloha nebyla nalezena.'
    },
    brands: {
      title: 'Výrobce',
      index: 'Výrobce',
      show: 'Detail výrobce',
      new: 'Nový výrobce',
      create: 'Přidat výrobce',
      edit: 'Upravit výrobce',
      delete: 'Odstranit výrobce',
      url: {
        product: 'Odkaz na product',
        sds: 'Odkaz na SDS File'
      },
      parse_callback: 'Parse Callback'
    },
    chemicals: {
      title: 'Chemikálie',
      index: 'Chemikálie',
      show: 'Detail chemikálie',
      new: 'Nová chemikálie',
      create: 'Přidat chemikálii',
      edit: 'Upravit chemikálii',
      delete: 'Odstranit chemikálii',
      search: {
        group: 'Seskupit položky podle výrobce',
        recent: 'Nově přidané chemikálie'
      },
      name: 'Název',
      synonym: 'Synonyma',
      iupac: 'IUPAC',
      brand: {
        _: 'Výrobce',
        id: 'ID výrobce',
        error: 'Chemikálie se stejným ID výrobce již existuje.'
      },
      cas: 'CAS',
      mw: 'Mol. hmotnost',
      formula: 'Sumární vzorec',
      pubchem: {
        _: 'PubChem',
        url: 'https://pubchem.ncbi.nlm.nih.gov/substance/{id}'
      },
      chemspider: {
        _: 'ChemSpider',
        url: 'https://www.chemspider.com/Chemical-Structure.{id}.html'
      },
      amount: 'Množství',
      unit: 'ks',
      owner: 'Majitel',
      'header.save': 'Nejdříve uložte hlavičku pro vložení položek k chemikálii.',
      structure: {
        _: 'Chemická struktura',
        edit: 'Upravit strukturu',
        draw: 'Vložit strukturu',
        inchikey: 'InChI Key',
        inchi: 'InChI',
        sdf: 'SDF',
        smiles: 'Smiles',
        not: {
          entered: 'Žádná chemická struktura nebyla vložena.',
          resolved: 'Chemická struktura nebyla rozpoznána.'
        }
      },
      data: {
        _: 'Stáhnout data',
        source: 'Zdroj',
        id: 'Identifikátor',
        results: 'Výsledky hledání',
        all: 'Stáhnout vše (SA + Cactus)',
        cactus: {
          _: 'Cactus NCI data',
          hint:
            'Použijte identifikátor (CAS, název, IUPAC, PubChem) pro stažení dat ze služby Cactus NCI service.',
          'not-found': "'{label}' nenalezeno pro '{search}'."
        },
        sigma: {
          _: 'Sigma Aldrich data',
          hint: 'Použijte kód produktu pro stažení dat od výrobce.',
          'not-found': "Produkt nenalezen pro '{search}'."
        },
        vendor: {
          _: 'Vendor data',
          hint: 'Použijte kód produktu pro stažení dat od výrobce.',
          'not-found': "Produkt nenalezen pro '{search}'."
        }
      },
      items: {
        _: 'Položka chemikálie',
        index: 'Skladové zásoby',
        none: 'Žádná položka chemikálie není skladem',
        create: 'Přidat chemikálii',
        move: {
          _: 'Přesunout vybrané',
          title: 'Přesunout vybrané položky do skladu',
          number: 'Množství vybraných položek k přesunu:'
        },
        'msg.moved': 'Vybrané položky byly přesunuty.'
      },
      errors: {
        store: 'Nemáte dostatečná oprávnění k modifikaci položek v tomto skladu.'
      }
    },
    common: {
      index: 'ChemLab',
      chemlab: 'ChemLab',
      home: 'Hlavní stránka',
      register: 'Registrace',
      login: 'Přihlásit se',
      login_with: 'Přihlásit se přes {provider}',
      logout: 'Odhlásit se',
      profile: 'Profil',
      other: 'Jiné',
      top: 'Nahoru',
      link: {
        _: 'Odkaz',
        public: ' Veřejný odkaz',
        external: 'Externí odkaz'
      },
      social: {
        facebook: 'Facebook',
        linkedin: 'LinkedIn',
        rss: 'RSS',
        twitter: 'Twitter',
        youtube: 'Youtube'
      },
      admin: 'Správa',
      lab: 'Laboratoř',
      acl: 'Správa přístupů',
      advanced: 'Pokročilé nastavení',
      misc: 'Různé',
      info: 'Informace',
      options: 'Možnosti',
      type: 'Druh',
      category: 'Kategorie',
      all: 'Vše',
      none: 'Žádný',
      select: {
        _: 'Vybrat',
        all: 'Vybrat vše',
        none: 'Odznačit vše'
      },
      not: {
        assigned: 'Nepřiřazeno',
        available: 'Není k dispozici',
        defined: 'Nedefinováno',
        selected: 'Nevybráno',
        entered: 'Nezadáno',
        limited: 'Neomezeno',
        restricted: 'Neomezeno'
      },
      error: 'Something went wrong!',
      'error.not-allowed': 'Nepovolená akce!',
      yes: 'Ano',
      true: 'Ano',
      no: 'Ne',
      false: 'Ne',
      add: 'Přidat',
      cancel: 'Zrušit',
      close: 'Zavřít',
      open: 'Otevřít',
      remove: 'Odebrat',
      submit: 'Potvrdit',
      save: 'Uložit',
      upload: 'Nahrát',
      send: 'Odeslat',
      search: {
        title: 'Hledat',
        filter: 'Filter',
        clear: 'Vymazat',
        advanced: 'Pokročilé vyhledávání',
        trashed: 'Zahrnout smazané záznamy'
      },
      filter: {
        role: 'Role',
        store: 'Sklad'
      },
      action: {
        _: 'Akce',
        audit: 'Audit',
        back: 'Zpět',
        clear: 'Vyčistit',
        create: 'Přidat',
        detail: 'Detail',
        download: 'Stáhnout',
        export: 'Export',
        insert: 'Vložit',
        load: 'Načíst',
        show: 'Info',
        structure: 'Struktura',
        submit: 'Vyhledat',
        transfer: 'Přesunout',
        print: 'Tisk',
        edit: 'Upravit',
        delete: 'Odstranit',
        restore: 'Obnovit',
        destroy: 'Trvale odstranit',
        multi: {
          delete: 'Smazat vybrané položky',
          restore: 'Obnovit vybrané položky'
        },
        confirm: {
          delete: 'Opravdu chcete odstranit: {name}?',
          restore: 'Opravdu chcete obnovit {name}?',
          multi: {
            delete: 'Vybrané položky položky budou smazány: {count}',
            restore: 'Vybrané položky položky budou obnoveny: {count}'
          }
        }
      },
      exports: {
        print: 'Tisk',
        csv: 'CSV',
        excel: 'Excel'
      },
      record: {
        title: 'Záznam',
        type: 'Typ záznamu',
        name: 'Název záznamu'
      },
      records: {
        count: 'Počet záznamů',
        selected: 'Počet vybraných záznamů'
      },
      name: 'Jméno',
      surname: 'Přijmení',
      id: 'ID',
      title: 'Název',
      title_internal: 'Interní název',
      email: 'Email',
      subject: 'Předmět',
      content: 'Obsah',
      message: 'Sdělení',
      text: 'Obsah',
      description: 'Popis',
      notes: 'Poznámky',
      size: 'Velikost',
      count: 'Počet',
      date: 'Datum',
      available_at: 'Dostupný',
      expires_at: 'Datum expirace',
      expired_at: 'Platnost vyprší',
      created_at: 'Vytvořeno',
      updated_at: 'Upraveno',
      deleted_at: 'Smazáno',
      year: 'Rok',
      terms: {
        consent: 'Souhlasím se zpracováním',
        privacy: 'osobních údajů.'
      },
      oauth2: {
        missing_email: 'Pro příhlášení je potřeba poskytnout platnou emailovou adresu.'
      },
      msg: {
        stored: 'Záznam ({name}) byl vytvořen.',
        updated: 'Záznam ({name}) byl upraven.',
        deleted: 'Záznam ({name}) byl odstraněn.',
        restored: 'Záznam ({name}) byl obnoven.',
        destroyed: 'Záznam ({name}) byl trvale odstraněn.',
        transferred: 'Záznam ({name}) byl přesunut.',
        multi: {
          deleted: 'Vybrané položky byly smazány.',
          restored: 'Vybrané položky byly obnoveny.'
        },
        registered:
          'Právě jste byl uspěšně registrován. Na email jsme Vám poslali instrukce jak plně aktivovat Váš účet.'
      }
    },
    jobs: {
      title: 'Úloha',
      index: 'Úlohy',
      show: 'Zobrazit úlohu',
      run: 'Spustit úlohu',
      delete: 'Smazat úlohu',
      none: 'Žádná úloha nebyla nalezena.',
      queue: 'Fronta',
      attempts: 'Opakování'
    },
    logs: {
      title: 'Log',
      index: 'Logy',
      show: 'Zobrazit log',
      delete: 'Odstranit log',
      none: 'Žádný log nebyl nalezen.'
    },
    mail: {
      greeting: 'Dobrý den',
      salutation: 'S pozdravem',
      subcopy:
        'Pokud máte problem s funkčností tlačítka "{action}", zkopírujte níže uvedevou adresu do Vašeho prohlížeče',
      'password.new.subject': 'Nastavení hesla k vašemu novému účtu',
      'password.new.notify':
        'Právě Vám byl vytvořen nový účet. Nastavte si prosím Vaše nové heslo k účtu přes níže uvedený odkaz.',
      'password.new.notify.error':
        'Pokud Vám byl účet vytvořen omylem, dejte nám prosím vědět nebo email ignorujte.',
      'password.reset.subject': 'Obnovení hesla k vašemu účtu',
      'password.reset.notify': 'Právě jsme obdrželi žádost o obnovení hesla k Vašemu účtu.',
      'password.reset.notify.error':
        'Pokud jste si obnovení hesla nevyžádal, prosím tento email ignorujte.',
      'password.reset.expire': 'Odkaz vyprší během následujících {count} minut.',
      'email.verify.subject': 'Ověření emailové adresy',
      'email.verify.action': 'Ověřit emailovou adresu',
      'email.verify.notify': 'Potvrďte Vaší emailovou adresu kliknutím na následující tlačítko.',
      'email.verify.notify.error':
        'Pokud jste si účet nevytvořili / nevyžádali, email prosím ignorujte.'
    },
    msds: {
      title: 'Bezpečnostní informace',
      sds: {
        _: 'Bezpečnostní list',
        download: 'Stáhnout',
        'not-found': 'Bezpečnostní list nenahrán.',
        vendor: 'Web výrobce'
      },
      symbol: 'Piktogram',
      signal_word: 'Signální slovo',
      h_title: 'Standardní věta o nebezpečnosti',
      h_abbr: 'H-věty',
      p_title: 'Pokyn pro bezpečné zacházení',
      p_abbr: 'P-věty',
      r_title: 'Rizikovost',
      r_abbr: 'R-věty',
      s_title: 'Pokyny pro bezpečné zacházení',
      s_abbr: 'S-věty',
      symbols: {
        GHS01: 'GHS01 - Vybuchující bomba',
        GHS02: 'GHS02 - Plamen',
        GHS03: 'GHS03 - Plamen nad kruhem',
        GHS04: 'GHS04 - Plynová láhev',
        GHS05: 'GHS05 - Korozivita',
        GHS06: 'GHS06 - Lebka se zkříženými hnáty',
        GHS07: 'GHS07 - Vykřičník',
        GHS08: 'GHS08 - Žíravost',
        GHS09: 'GHS09 - Nebezpečnost pro zdraví'
      },
      h: {
        H200: 'H200 - Nestabilní výbušnina.',
        H201: 'H201 - Výbušnina; nebezpečí masivního výbuchu.',
        H202: 'H202 – Výbušnina; vážné nebezpečí zasažení částicemi.',
        H203: 'H203 – Výbušnina; nebezpečí požáru, tlakové vlny nebo zasažení částicemi.',
        H204: 'H204 – Nebezpečí požáru nebo zasažení částicemi.',
        H205: 'H205 – Při požáru může způsobit masivní výbuch.',
        H220: 'H220 – Extrémně hořlavý plyn.',
        H221: 'H221 – Hořlavý plyn.',
        H222: 'H222 – Extrémně hořlavý aerosol.',
        H223: 'H223 – Hořlavý aerosol.',
        H224: 'H224 – Extrémně hořlavá kapalina a páry.',
        H225: 'H225 – Vysoce hořlavá kapalina a páry.',
        H226: 'H225 – Vysoce hořlavá kapalina a páry.',
        H228: 'H228 – Hořlavá tuhá látka.',
        H240: 'H240 – Zahřívání může způsobit výbuch.',
        H241: 'H241 – Zahřívání může způsobit požár nebo výbuch.',
        H242: 'H242 – Zahřívání může způsobit požár.',
        H250: 'H250 – Při styku se vzduchem se samovolně vznítí.',
        H251: 'H251 – Samovolně se zahřívá: může se vznítit.',
        H252: 'H252 – Ve velkém množství se samovolně zahřívá; může se vznítit.',
        H260: 'H260 – Při styku s vodou uvolňuje hořlavé plyny, které se mohou samovolně vznítit.',
        H261: 'H261 – Při styku s vodou uvolňuje hořlavé plyny.',
        H270: 'H270 – Může způsobit nebo zesílit požár; oxidant.',
        H271: 'H271 – Může způsobit požár nebo výbuch; silný oxidant.',
        H272: 'H272 – Může zesílit požár; oxidant.',
        H280: 'H280 – Obsahuje plyn pod tlakem; při zahřívání může vybuchnout.',
        H281: 'H281 – Obsahuje zchlazený plyn; může způsobit omrzliny nebo poškození chladem.',
        H290: 'H290 – Může být korozivní pro kovy.',
        H300: 'H300 – Při požití může způsobit smrt.',
        H301: 'H301 – Toxický při požití.',
        H302: 'H302 – Zdraví škodlivý při požití.',
        H304: 'H304 – Při požití a vniknutí do dýchacích cest může způsobit smrt.',
        H310: 'H310 – Při styku s kůží může způsobit smrt.',
        H311: 'H311 – Toxický při styku s kůží.',
        H312: 'H312 – Zdraví škodlivý při styku s kůží.',
        H314: 'H314 – Způsobuje těžké poleptání kůže a poškození očí.',
        H315: 'H315 – Dráždí kůži.',
        H317: 'H317 – Může vyvolat alergickou kožní reakci.',
        H318: 'H318 – Způsobuje vážné poškození očí.',
        H319: 'H319 – Způsobuje vážné podráždění očí.',
        H330: 'H330 – Při vdechování může způsobit smrt.',
        H331: 'H331 – Toxický při vdechování.',
        H332: 'H332 – Zdraví škodlivý při vdechování.',
        H334:
          'H334 – Při vdechování může vyvolat příznaky alergie nebo astmatu nebo dýchací potíže.',
        H335: 'H335 – Může způsobit podráždění dýchacích cest.',
        H336: 'H336 – Může způsobit ospalost nebo závratě.',
        H340: 'H340 – Může vyvolat genetické poškození.',
        H341: 'H341 – Podezření na genetické poškození.',
        H350: 'H350 - H350 – Může vyvolat rakovinu .',
        H351: 'H351 – Podezření na vyvolání rakoviny .',
        H360: 'H360 - Může poškodit reprodukční schopnost nebo plod v těle matky.',
        H361: 'H361 – Podezření na poškození reprodukční schopnosti nebo plodu v těle matky.',
        H362: 'H362 – Může poškodit kojence prostřednictvím mateřského mléka.',
        H370: 'H370 – Způsobuje poškození orgánů.',
        H371: 'H371 – Může způsobit poškození orgánů.',
        H372:
          'H372 – Způsobuje poškození orgánů při prodloužené nebo opakované expozici; ostatní cesty expozice nejsou nebezpečné.',
        H373:
          'H373 – Může způsobit poškození orgánů při prodloužené nebo opakované expozici; ostatní cesty expozice nejsou nebezpečné.',
        H400: 'H400 – Vysoce toxický pro vodní organismy.',
        H410: 'H410 – Vysoce toxický pro vodní organismy, s dlouhodobými účinky.',
        H411: 'H411 – Toxický pro vodní organismy, s dlouhodobými účinky.',
        H412: 'H412 – Škodlivý pro vodní organismy, s dlouhodobými účinky.',
        H413: 'H413 – Může vyvolat dlouhodobé škodlivé účinky pro vodní organismy.',
        'H300+H310': 'H300+H310 - Při požití nebo styku s kůží může způsobit smrt.',
        'H300+H330': 'H300+H330 - Při požití nebo vdechování může způsobit smrt.',
        'H310+H330': 'H310+H330 - Při styku s kůží nebo vdechování může způsobit smrt',
        'H300+H310+H330':
          'H300+H310+H330 - Při požití, styku s kůží nebo nebo vdechování může způsobit smrt',
        'H301+H311': 'H301+H311 - Toxický při požití nebo styku s kůží.',
        'H301+H331': 'H301+H331 - Toxický při požití nebo vdechování.',
        'H311+H331': 'H311+H331 - Toxický při styku s kůží nebo vdechování.',
        'H301+H311+H331': 'H301+H311+H331 - Toxický při požití, styku s kůží nebo vdechování.',
        'H302+H312': 'H302+H312 - Zdraví škodlivý při požití nebo styku s kůží..',
        'H302+H332': 'H302+H332 - Zdraví škodlivý při požití nebo vdechování.',
        'H312+H332': 'H312+H332 - Zdraví škodlivý při styku s kůží nebo vdechování.',
        'H302+H312+H332':
          'H302+H312+H332 - Zdraví škodlivý při požití, styku s kůží nebo vdechování.',
        EUH001: 'EUH001 – Výbušný v suchém stavu.',
        EUH006: 'EUH006 – Výbušný za přístupu i bez přístupu vzduchu.',
        EUH014: 'EUH014 – Prudce reaguje s vodou.',
        EUH018: 'EUH018 – Při používání může vytvářet hořlavé nebo výbušné směsi par se vzduchem.',
        EUH019: 'EUH019 – Může vytvářet výbušné peroxidy.',
        EUH044: 'EUH044 – Nebezpečí výbuchu při zahřátí v uzavřeném obalu.',
        EUH029: 'EUH029 – Uvolňuje toxický plyn při styku s vodou.',
        EUH031: 'EUH031 – Uvolňuje toxický plyn při styku s kyselinami.',
        EUH032: 'EUH032 – Uvolňuje vysoce toxický plyn při styku s kyselinami.',
        EUH066: 'EUH066 – Opakovaná expozice může způsobit vysušení nebo popraskání kůže.',
        EUH070: 'EUH070 – Toxický při styku s očima.',
        EUH071: 'EUH071 – Způsobuje poleptání dýchacích cest.',
        EUH059: 'EUH059 – Nebezpečný pro ozonovou vrstvu.',
        EUH201:
          'EUH201 – Obsahuje olovo. Nemá se používat na povrchy, které mohou okusovat nebo olizovat děti.',
        EUH201A: 'EUH201A – Pozor! Obsahuje olovo.',
        EUH202:
          'EUH202 – Kyanoakrylát. Nebezpečí. Okamžitě slepuje kůži a oči. Uchovávejte mimo dosah dětí.',
        EUH203: 'EUH203 – Obsahuje chrom (VI). Může vyvolat alergickou reakci.',
        EUH204: 'EUH204 – Obsahuje isokyanáty. Může vyvolat alergickou reakci.',
        EUH205: 'EUH205 – Obsahuje epoxidové složky. Může vyvolat alergickou reakci.',
        EUH206:
          'EUH206 – Pozor! Nepoužívejte společně s jinými výrobky. Může uvolňovat nebezpečné plyny (chlor).',
        EUH207:
          'EUH207 – Pozor! Obsahuje kadmium. Při používání vznikají nebezpečné výpary. Viz informace dodané výrobcem. Dodržujte bezpečnostní pokyny.',
        EUH208: 'EUH208 – Obsahuje.  Může vyvolat alergickou reakci.',
        EUH209: 'EUH209 – Při používání se může stát vysoce hořlavým.',
        EUH209A: 'EUH209A – Při používání se může stát hořlavým.',
        EUH210: 'EUH210 – Na vyžádání je kodispozici bezpečnostní list.',
        EUH401:
          'EUH401 – Dodržujte pokyny pro používání, abyste se vyvarovali rizik pro lidské zdraví a životní prostředí.'
      },
      p: {
        P101: 'P101 – Je-li nutná lékařská pomoc, mějte po ruce obal nebo štítek výrobku.',
        P102: 'P102 – Uchovávejte mimo dosah dětí.',
        P103: 'P103 – Před použitím si přečtěte údaje na štítku.',
        P201: 'P201 – Před použitím si obstarejte speciální instrukce.',
        P202:
          'P202 – Nepoužívejte, dokud jste si nepřečetli všechny bezpečnostní pokyny a neporozuměli jim.',
        P210:
          'P210 – Chraňte před teplem/jiskrami/otevřeným plamenem/horkými povrchy. – Zákaz kouření.',
        P211: 'P211 – Nestříkejte do otevřeného ohně nebo jiných zdrojů zapálení.',
        P220: 'P220 – Uchovávejte/skladujte odděleně od oděvů/…/hořlavých materiálů.',
        P221: 'P221 – Proveďte preventivní opatření proti smíchání s hořlavými materiály…',
        P222: 'P222 – Zabraňte styku se vzduchem.',
        P223:
          'P223 – Chraňte před možným stykem s vodou kvůli prudké reakci a možnému náhlému vzplanutí.',
        P230: 'P230 - Uchovávejte ve zvlhčeném stavu …',
        P231: 'P231 – Manipulace pod inertním plynem.',
        P232: 'P232 – Chraňte před vlhkem.',
        P233: 'P233 – Uchovávejte obal těsně uzavřený.',
        P234: 'P234 – Uchovávejte pouze v původním obalu.',
        P235: 'P235 – Uchovávejte v chladu.',
        P240: 'P240 – Uzemněte obal a odběrové zařízení.',
        P241:
          'P241 – Používejte elektrické/ventilační/osvětlovací/…/zařízení do výbušného prostředí.',
        P242: 'P242 – Používejte pouze nářadí z nejiskřícího kovu.',
        P243: 'P243 – Proveďte preventivní opatření proti výbojům statické elektřiny.',
        P244: 'P244 – Udržujte redukční ventily bez maziva a oleje.',
        P250: 'P250 – Nevystavujte obrušování/nárazům/…/tření.',
        P251: 'P251 – Tlakový obal: nepropichujte nebo nespalujte ani po použití.',
        P260: 'P260 – Nevdechujte prach/dým/plyn/mlhu/páry/aerosoly.',
        P261: 'P261 – Zamezte vdechování prachu/dýmu/plynu/mlhy/par/aerosolů.',
        P262: 'P262 – Zabraňte styku s očima, kůží nebo oděvem.',
        P263: 'P263 – Zabraňte styku během těhotenství/kojení.',
        P264: 'P264 – Po manipulaci důkladně omyjte ….',
        P270: 'P270 – Při používání tohoto výrobku nejezte, nepijte ani nekuřte.',
        P271: 'P271 – Používejte pouze venku nebo v dobře větraných prostorách.',
        P272: 'P272 – Kontaminovaný pracovní oděv neodnášejte z pracoviště.',
        P273: 'P273 – Zabraňte uvolnění do životního prostředí.',
        P280: 'P280 – Používejte ochranné rukavice/ochranný oděv/ochranné brýle/obličejový štít.',
        P281: 'P281 – Používejte požadované osobní ochranné prostředky.',
        P282: 'P282 – Používejte ochranné rukavice proti chladu/obličejový štít/ochranné brýle.',
        P283: 'P283 – Používejte ohnivzdorný/nehořlavý oděv.',
        P284: 'P284 – Používejte vybavení pro ochranu dýchacích cest.',
        P285:
          'P285 – V případě nedostatečného větrání používejte vybavení pro ochranu dýchacích cest.',
        'P231+P232': 'P231+P232 – Manipulace pod inertním plynem. Chraňte před vlhkem.',
        'P235+P410': 'P235+P410 – Uchovávejte v chladu. Chraňte před slunečním zářením.',
        P301: 'P301 – PŘI POŽITÍ:',
        P302: 'P302 – PŘI STYKU S KŮŽÍ:',
        P303: 'P303 – PŘI STYKU S KŮŽÍ (nebo s vlasy):',
        P304: 'P304 – PŘI VDECHNUTÍ:',
        P305: 'P305 – PŘI ZASAŽENÍ OČÍ:',
        P306: 'P306 – PŘI STYKU S ODĚVEM:',
        P307: 'P307 – PŘI expozici:',
        P308: 'P308 – PŘI expozici nebo podezření na ni:',
        P309: 'P309 – PŘI expozici nebo necítíte-li se dobře:',
        P310: 'P310 – Okamžitě volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        P311: 'P311 – Volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        P312:
          'P312 – Necítíte-li se dobře, volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        P313: 'P313 – Vyhledejte lékařskou pomoc/ošetření.',
        P314: 'P314 – Necítíte-li se dobře, vyhledejte lékařskou pomoc/ošetření.',
        P315: 'P315 – Okamžitě vyhledejte lékařskou pomoc/ošetření.',
        P320: 'P320 – Je nutné odborné ošetření (viz … na tomto štítku).',
        P321: 'P321 – Odborné ošetření (viz … na tomto štítku).',
        P322: 'P322 – Specifické opatření (viz … na tomto štítku).',
        P330: 'P330 – Vypláchněte ústa.',
        P331: 'P331 – NEVYVOLÁVEJTE zvracení.',
        P332: 'P332 – Při podráždění kůže:',
        P333: 'P333 – Při podráždění kůže nebo vyrážce:',
        P334: 'P334 – Ponořte do studené vody/zabalte do vlhkého obvazu.',
        P335: 'P335 – Volné částice odstraňte z kůže.',
        P336: 'P336 – Omrzlá místa ošetřete vlažnou vodou. Postižené místo netřete.',
        P337: 'P337 – Přetrvává-li podráždění očí:',
        P338:
          'P338 – Vyjměte kontaktní čočky, jsou-li nasazeny a pokud je lze vyjmout snadno. Pokračujte ve vyplachování.',
        P340:
          'P340 – Přeneste postiženého na čerstvý vzduch a ponechte jej v klidu v poloze usnadňující dýchání.',
        P341:
          'P341 – Při obtížném dýchání přeneste postiženého na čerstvý vzduch a ponechte jej v klidu v poloze usnadňující dýchání.',
        P342: 'P342 – Při dýchacích potížích:',
        P350: 'P350 – Jemně omyjte velkým množstvím vody a mýdla.',
        P351: 'P351 – Několik minut opatrně oplachujte vodou.',
        P352: 'P352 – Omyjte velkým množstvím vody a mýdla.',
        P353: 'P353 – Opláchněte kůži vodou/osprchujte.',
        P360:
          'P360 – Kontaminovaný oděv a kůži okamžitě omyjte velkým množstvím vody a potom oděv odložte.',
        P361: 'P361 – Veškeré kontaminované části oděvu okamžitě svlékněte.',
        P362: 'P362 – Kontaminovaný oděv svlékněte a před opětovným použitím ho vyperte.',
        P363: 'P363 – Kontaminovaný oděv před opětovným použitím vyperte.',
        P370: 'P370 – V případě požáru:',
        P371: 'P371 – V případě velkého požáru a velkého množství:',
        P372: 'P372 – Nebezpečí výbuchu v případě požáru.',
        P373: 'P373 – Požár NEHASTE, dostane-li se k výbušninám.',
        P374: 'P374 – Haste z přiměřené vzdálenosti a dodržujte běžná opatření.',
        P375: 'P375 – Kvůli nebezpečí výbuchu haste z dostatečné vzdálenosti.',
        P376: 'P376 – Zastavte únik, můžete-li tak učinit bez rizika.',
        P377: 'P377 – Požár unikajícího plynu: Nehaste, nelze-li únik bezpečně zastavit.',
        P378: 'P378 – K hašení použijte ….',
        P380: 'P380 – Vykliďte _roctor.',
        P381: 'P381 – Odstraňte všechny zdroje zapálení, můžete-li tak učinit bez rizika.',
        P390: 'P390 – Uniklý produkt absorbujte, aby se zabránilo materiálním škodám.',
        P391: 'P391 – Uniklý produkt seberte.',
        'P301+P310':
          'P301+P310 - PŘI POŽITÍ: Okamžitě volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        'P301+P312':
          'P301+P312 - PŘI POŽITÍ: Necítíte-li se dobře, volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        'P301+P330+P331': 'P301+P330+P331 - PŘI POŽITÍ: Vypláchněte ústa. NEVYVOLÁVEJTE zvracení.',
        'P302+P334':
          'P302+P334 - PŘI STYKU S KŮŽÍ: Ponořte do studené vody/zabalte do vlhkého obvazu.',
        'P302+P350': 'P302+P350 - PŘI STYKU S KŮŽÍ: Jemně omyjte velkým množstvím vody a mýdla.',
        'P302+P352': 'P302+P353 - PŘI STYKU S KŮŽÍ: Omyjte velkým množstvím vody a mýdla.',
        'P303+P361+P353':
          'P303+P361+P353 - PŘI STYKU S KŮŽÍ (nebo s vlasy): Veškeré kontaminované části oděvu okamžitě svlékněte. Opláchněte kůži vodou/osprchujte.',
        'P304+P340':
          'P304+P340 - PŘI VDECHNUTÍ: Přeneste postiženého na čerstvý vzduch a ponechte jej v klidu v poloze usnadňující dýchání.',
        'P304+P341':
          'P304+P341 - PŘI VDECHNUTÍ: Při obtížném dýchání přeneste postiženého na čerstvý vzduch a ponechte jej v klidu v poloze usnadňující dýchání.',
        'P305+P351+P338':
          'P305+P351+P338 - PŘI ZASAŽENÍ OČÍ: Několik minut opatrně vyplachujte vodou. Vyjměte kontaktní čočky, jsou-li nasazeny a pokud je lze vyjmout snadno. Pokračujte ve vyplachování.',
        'P306+P360':
          'P306+P360 - PŘI STYKU S ODĚVEM: Kontaminovaný oděv a kůži oklamžitě omyjte velkým množstvím vody a potom oděv odložte.',
        'P307+P311':
          'P307+P311 - PŘI expozici: Volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        'P308+P313':
          'P308+P313 - PŘI expozici nebo podezření na ni: Vyhledejte lékařskou pomoc/ošetření.',
        'P309+P311':
          'P309+P311 - PŘI expozici nebo necítíte-li se dobře: Volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        'P332+P313': 'P332+P313 - Při podráždění kůže: Vyhledejte lékařskou pomoc/ošetření.',
        'P333+P313':
          'P333+P313 - Při podráždění kůže nebo vyrážce: Vyhledejte lékařskou pomoc/ošetření.',
        'P335+P334':
          'P335+P334 - Volné částice odstraňte z kůže. Ponořte do studené vody/zabalte do vlhkého obvazu.',
        'P337+P313':
          'P337+P313 - Přetrvává-li podráždění očí: Vyhledejte lékařskou pomoc/ošetření.',
        'P342+P311':
          'P342+P311 - Při dýchacích potížích: Volejte TOXIKOLOGICKÉ INFORMAČNÍ STŘEDISKO nebo lékaře.',
        'P370+P376':
          'P370+P376 - V případě požáru: Zastavte únik, můžete-li tak učinit bez rizika.',
        'P370+P378': 'P370+P378 - V případě požáru: K hašení použijte ….',
        'P370+P380': 'P101 - V případě požáru: Vykliďte prostor.',
        'P370+P380+P375':
          'P370+P380+P375 - V případě požáru: Vykliďte prostor. Kvůli nebezpečí výbuchu haste z dostatečné vzdálenosti.',
        'P371+P380+P375':
          'P371+P380+P375 - V případě velkého požáru a velkého množství: Vykliďte prostor. Kvůli nebezpečí výbuchu haste z dostatečné vzdálenosti.',
        P401: 'P401 - Skladujte …',
        P402: 'P402 - Skladujte na suchém místě.',
        P403: 'P403 - Skladujte na dobře větraném místě.',
        P404: 'P404 - Skladujte v uzavřeném obalu.',
        P405: 'P405 - Skladujte uzamčené.',
        P406: 'P406 - Skladujte v obalu odolném proti korozi/… obalu s odolnou vnitřní vrstvou.',
        P407: 'P407 - Mezi stohy/paletami ponechte vzduchovou mezeru.',
        P410: 'P410 - Chraňte před slunečním zářením.',
        P411: 'P411 - Skladujte při teplotě nepřesahující … oC/…oF.',
        P412: 'P412 - Nevystavujte teplotě přesahující 50 oC/122 oF',
        P413:
          'P413 - Množství větší než … kg/… liber skladujte při teplotě nepřesahující … oC/…oF.',
        P420: 'P420 - Skladujte odděleně od ostatních materiálů.',
        P422: 'P422 - Skladujte pod …',
        'P402+P404': 'P402+P404 - Skladujte na suchém místě. Skladujte v uzavřeném obalu.',
        'P403+P233':
          'P403+P233 - Skladujte na dobře větraném místě. Uchovávejte obal těsně uzavřený.',
        'P403+P235': 'P403+P235 - Skladujte na dobře větraném místě. Uchovávejte v chladu.',
        'P410+P403':
          'P410+P403 - Chraňte před slunečním zářením. Skladujte na dobře větraném místě.',
        'P410+P412':
          'P410+P412 - Chraňte před slunečním zářením. Nevystavujte teplotě přesahující 50 oC/122oF.',
        'P411+P235':
          'P411+P235 - Skladujte při teplotě nepřesahující … oC/…oF. Uchovávejte v chladu.',
        P501: 'P501 - Odstraňte obsah/obal …',
        P502: 'P502 - Refer to manufacturer/supplier for information on recovery/recycling'
      },
      r: {
        R1: 'R1 - Výbušný v suchém stavu.',
        R2: 'R2 - Nebezpečí výbuchu při úderu, tření, ohni nebo působením jiných zdrojů zapálení.',
        R3:
          'R3 - Velké nebezpečí výbuchu při úderu, tření, ohni nebo působením jiných zdrojů zapálení.',
        R4: 'R4 - Vytváří vysoce výbušné kovové sloučeniny.',
        R5: 'R5 - Zahřívání může způsobit výbuch.',
        R6: 'R6 - Výbušný za přístupu i bez přístupu vzduchu.',
        R7: 'R7 - Může způsobit požár.',
        R8: 'R8 - Dotek s hořlavým materiálem může způsobit požár.',
        R9: 'R9 - Výbušný při smíchání s hořlavým materiálem.',
        R10: 'R10 - Hořlavý.',
        R11: 'R11 - Vysoce hořlavý.',
        R12: 'R12 - Extrémně hořlavý.',
        R14: 'R14 - Prudce reaguje s vodou.',
        R15: 'R15 - Při styku s vodou uvolňuje extrémně hořlavé plyny.',
        R16: 'R16 - Výbušný při smíchání s oxidačními látkami.',
        R17: 'R17 - Samovznětlivý na vzduchu.',
        R18: 'R18 - Při používání může vytvářet hořlavé nebo výbušné směsi par se vzduchem.',
        R19: 'R19 - Může vytvářet výbušné peroxidy.',
        R20: 'R20 - Zdraví škodlivý při vdechování.',
        R21: 'R21 - Zdraví škodlivý při styku s kůží.',
        R22: 'R22 - Zdraví škodlivý při požití.',
        R23: 'R23 - Toxický při vdechování.',
        R24: 'R24 - Toxický při styku s kůží.',
        R25: 'R25 - Toxický při požití.',
        R26: 'R26 - Vysoce toxický při vdechování.',
        R27: 'R27 - Vysoce toxický při styku s kůží.',
        R28: 'R28 - Vysoce toxický při požití.',
        R29: 'R29 - Uvolňuje toxický plyn při styku s vodou.',
        R30: 'R30 - Při používání se může stát vysoce hořlavým.',
        R31: 'R31 - Uvolňuje toxický plyn při styku s kyselinami.',
        R32: 'R32 - Uvolňuje vysoce toxický plyn při styku s kyselinami.',
        R33: 'R33 - Nebezpečí kumulativních účinků.',
        R34: 'R34 - Způsobuje poleptání.',
        R35: 'R35 - Způsobuje těžké poleptání.',
        R36: 'R36 - Dráždí oči.',
        R37: 'R37 - Dráždí dýchací orgány.',
        R38: 'R38 - Dráždí kůži.',
        R39: 'R39 - Nebezpečí velmi vážných nevratných účinků.',
        R40: 'R40 - Podezření na karcinogenní účinky.',
        R41: 'R41 - Nebezpečí vážného poškození očí.',
        R42: 'R42 - Může vyvolat senzibilizaci při vdechování.',
        R43: 'R43 - Může vyvolat senzibilizaci při styku s kůží.',
        R44: 'R44 - Nebezpečí výbuchu při zahřátí v uzavřeném obalu.',
        R45: 'R45 - Může vyvolat rakovinu.',
        R46: 'R46 - Může vyvolat poškození dědičných vlastností.',
        R48: 'R48 - Při dlouhodobé expozici nebezpečí vážného poškození zdraví.',
        R49: 'R49 - Může vyvolat rakovinu při vdechování.',
        R50: 'R50 - Vysoce toxický pro vodní organismy.',
        R51: 'R51 - Toxický pro vodní organismy.',
        R52: 'R52 - Škodlivý pro vodní organismy.',
        R53: 'R53 - Může vyvolat dlouhodobé nepříznivé účinky ve vodním prostředí.',
        R54: 'R54 - Toxický pro rostliny.',
        R55: 'R55 - Toxický pro živočichy.',
        R56: 'R56 - Toxický pro půdní organismy.',
        R57: 'R57 - Toxický pro včely.',
        R58: 'R58 - Může vyvolat dlouhodobé nepříznivé účinky v životním prostředí.',
        R59: 'R59 - Nebezpečný pro ozonovou vrstvu.',
        R60: 'R60 - Může poškodit reprodukční schopnost.',
        R61: 'R61 - Může poškodit plod v těle matky.',
        R62: 'R62 - Možné nebezpečí poškození reprodukční schopnosti.',
        R63: 'R63 - Možné nebezpečí poškození plodu v těle matky.',
        R64: 'R64 - Může poškodit kojené dítě.',
        R65: 'R65 - Zdraví škodlivý: při požití může vyvolat poškození plic.',
        R66: 'R66 - Opakovaná expozice může způsobit vysušení nebo popraskání kůže.',
        R67: 'R67 - Vdechování par může způsobit ospalost a závratě.',
        R68: 'R68 - Možné nebezpečí nevratných účinků.',
        'R14/15': 'R14/15 - Prudce reaguje s vodou za uvolňování extrémně hořlavých plynů.',
        'R15/29': 'R15/29 - Při styku s vodou uvolňuje toxický, extrémně hořlavý plyn.',
        'R20/21': 'R20/21 - Zdraví škodlivý při vdechování a při styku s kůží.',
        'R20/22': 'R20/22 - Zdraví škodlivý při vdechování a při požití.',
        'R21/22': 'R21/22 - Zdraví škodlivý při styku s kůží a při požití.',
        'R20/21/22': 'R20/21/22 - Zdraví škodlivý při vdechování, styku s kůží a při požití.',
        'R23/24': 'R23/24 - Toxický při vdechování a při styku s kůží.',
        'R24/25': 'R24/25 - Toxický při styku s kůží a při požití.',
        'R23/25': 'R23/25 - Toxický při vdechování a při požití.',
        'R23/24/25': 'R23/24/25 - Toxický při vdechování, styku s kůží a při požití.',
        'R26/27': 'R26/27 - Vysoce toxický při vdechování a při styku s kůží.',
        'R26/28': 'R26/28 - Vysoce toxický při vdechování a při požití.',
        'R26/27/28': 'R26/27/28 - Vysoce toxický při vdechování, styku s kůží a při požití.',
        'R27/28': 'R27/28 - Vysoce toxický při styku s kůží a při požití.',
        'R36/37': 'R36/37 - Dráždí oči a dýchací orgány.',
        'R36/38': 'R36/38 - Dráždí oči a kůži.',
        'R37/38': 'R37/38 - Dráždí dýchací orgány a kůži.',
        'R36/37/38': 'R36/37/38 - Dráždí oči, dýchací orgány a kůži.',
        'R39/23': 'R39/23 - Toxický: nebezpečí velmi vážných nevratných účinků při vdechování.',
        'R39/24': 'R39/24 - Toxický: nebezpečí velmi vážných nevratných účinků při styku s kůží.',
        'R39/25': 'R39/25 - Toxický: nebezpečí velmi vážných nevratných účinků při požití.',
        'R39/32/24':
          'R39/23/24 - Toxický: nebezpečí velmi vážných nevratných účinků při vdechování a při styku s kůží',
        'R39/23/25':
          'R39/23/25 - Toxický: nebezpečí velmi vážných nevratných účinků při vdechování a při požití.',
        'R39/24/25':
          'R39/24/25 - Toxický: nebezpečí velmi vážných nevratných účinků při styku s kůží a při požití.',
        'R39/23/24/25':
          'R39/23/24/25 - Toxický: nebezpečí velmi vážných nevratných účinků při vdechování, styku s kůží a při požití.',
        'R39/26':
          'R39/26 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při vdechování.',
        'R39/26/27':
          'R39/26/27 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při vdechování a při styku s kůží.',
        'R39/27':
          'R39/27 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při styku s kůží.',
        'R39/28': 'R39/28 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při požití.',
        'R39/26/28':
          'R39/26/28 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při vdechování a při požití.',
        'R39/27/28':
          'R39/27/28 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při styku s kůží a při požití.',
        'R39/26/27/28':
          'R39/26/27/28 - Vysoce toxický: nebezpečí velmi vážných nevratných účinků při vdechování, styku s kůží a při požití.',
        'R68/20': 'R68/20 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při vdechování.',
        'R68/21': 'R68/21 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při styku s kůží.',
        'R68/22': 'R68/22 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při požití.',
        'R68/20/21':
          'R68/20/21 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při vdechování a při styku s kůží.',
        'R68/20/22':
          'R68/20/22 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při vdechování a při požití.',
        'R68/21/22':
          'R68/21/22 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při styku s kůží a při požití.',
        'R68/20/21/22':
          'R68/20/21/22 - Zdraví škodlivý: Možné nebezpečí nevratných účinků při vdechování, při styku s kůží a při požití.',
        'R42/43': 'R42/43 - Může vyvolat senzibilizaci při vdechování a při styku s kůží.',
        'R48/20':
          'R48/20 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním.',
        'R48/21':
          'R48/21 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici stykem s kůží.',
        'R48/22':
          'R48/22 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici požíváním.',
        'R48/20/21':
          'R48/20/21 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním a stykem s kůží.',
        'R48/20/22':
          'R48/20/22 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním a požíváním.',
        'R48/21/22':
          'R48/21/22 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici stykem s kůží a požíváním.',
        'R48/20/21/22':
          'R48/20/21/22 - Zdraví škodlivý: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním, stykem s kůží a požíváním.',
        'R48/23':
          'R48/23 - Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním.',
        'R48/24':
          'R48/24 - Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici stykem s kůží.',
        'R48/25':
          'R48/25 - Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici požíváním.',
        'R48/23/24':
          'R48/23/24 -Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním a stykem s kůží.',
        'R48/23/25':
          'R48/23/25 - Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním a požíváním.',
        'R48/24/25':
          'R48/24/25 - Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici stykem s kůží a požíváním.',
        'R48/23/24/25':
          'R48/23/24/25 - Toxický: nebezpečí vážného poškození zdraví při dlouhodobé expozici vdechováním, stykem s kůží a požíváním.',
        'R50/53':
          'R50/53 - Vysoce toxický pro vodní organismy, může vyvolat dlouhodobé nepříznivé účinky ve vodním prostředí.',
        'R51/53':
          'R51/53 - Toxický pro vodní organismy, může vyvolat dlouhodobé nepříznivé účinky ve vodním prostředí.',
        'R52/53':
          'R52/53 - R52/53 - Škodlivý pro vodní organismy, může vyvolat dlouhodobé nepříznivé účinky ve vodním prostředí.'
      },
      s: {
        S1: 'S1 - Uchovávejte uzamčené',
        S2: 'S2 - Uchovávejte mimo dosah dětí',
        S3: 'S3 - Uchovávejte na chladném místě',
        S4: 'S4 - Uchovávejte mimo obytné objekty',
        S5: 'S5 - Uchovávejte pod ….. (příslušnou kapalinu specifikuje výrobce)',
        S6: 'S6 - Uchovávejte pod ….. (inertní plyn specifikuje výrobce)',
        S7: 'S7 - Uchovávejte obal těsně uzavřený',
        S8: 'S8 - Uchovávejte obal suchý',
        S9: 'S9 - Uchovávejte obal na dobře větraném místě',
        S12: 'S12 - Neuchovávejte obal těsně uzavřený',
        S13: 'S13 - Uchovávejte odděleně od potravin, nápojů a krmiv',
        S14: 'S14 - Uchovávejte odděleně od ….. (vzájemně se vylučující látky uvede výrobce)',
        S15: 'S15 - Chraňte před teplem',
        S16: 'S16 - Uchovávejte mimo dosah zdrojů zapálení - Zákaz kouření',
        S17: 'S17 - Uchovávejte mimo dosah hořlavých materiálů',
        S18: 'S18 - Zacházejte s obalem opatrně a opatrně jej otevírejte',
        S20: 'S20- Nejezte a nepijte při používání',
        S21: 'S21 - Nekuřte při používání',
        S22: 'S22 - Nevdechujte prach',
        S23: 'S23 - Nevdechujte plyny/dýmy/páry/aerosoly (příslušný výraz specifikuje výrobce)',
        S24: 'S24 - Zamezte styku s kůží',
        S25: 'S25 - Zamezte styku s očima',
        S26:
          'S26 - Při zasažení očí okamžitě důkladně vypláchněte vodou a vyhledejte lékařskou pomoc',
        S27: 'S27 - Okamžitě odložte veškeré kontaminované oblečení',
        S28:
          'S28 - Při styku s kůží okamžitě omyjte velkým množstvím ….. (vhodnou kapalinu specifikuje výrobce)',
        S29: 'S29 - Nevylévejte do kanalizace',
        S30: 'S30 - K tomuto výrobku nikdy nepřidávejte vodu',
        S33: 'S33 - Proveďte preventivní opatření proti výbojům statické elektřiny',
        S35: 'S35 - Tento materiál a jeho obal musí být zneškodněny bezpečným způsobem',
        S36: 'S36 - Používejte vhodný ochranný oděv',
        S37: 'S37 - Používejte vhodné ochranné rukavice',
        S38:
          'S38 - V případě nedostatečného větrání používejte vhodné vybavení pro ochranu dýchacích orgánů',
        S39: 'S39 - Používejte osobní ochranné prostředky pro oči a obličej',
        S40:
          'S40 - Podlahy a předměty znečistěné tímto materiálem čistěte ….. (specifikuje výrobce)',
        S41: 'S41 - V případě požáru nebo výbuchu nevdechujte dýmy',
        S42:
          'S42 - Při fumigaci nebo rozprašování používejte vhodný ochranný prostředek k ochraně dýchacích orgánů (specifikaci uvede výrobce)',
        S43:
          'S43 - V případě požáru použijte ….. (uveďte zde konkrétní typ hasicího zařízení. Pokud zvyšuje riziko voda, připojte "Nikdy nepoužívat vodu")',
        S45:
          'S45 - V případě nehody, nebo necítíte-li se dobře, okamžitě vyhledejte lékařskou pomoc (je-li možno, ukažte toto označení)',
        S46:
          'S46 - Při požití okamžitě vyhledejte lékařskou pomoc a ukažte tento obal nebo označení',
        S47: 'S47 - Uchovávejte při teplotě nepřesahující ….. °C (specifikuje výrobce)',
        S48: 'S48 - Uchovávejte ve zvlhčeném stavu ….. (vhodnou látku specifikuje výrobce)',
        S49: 'S49 - Uchovávejte pouze v původním obalu',
        S50: 'S50 - Nesměšujte s ….. (specifikuje výrobce)',
        S51: 'S51 - Používejte pouze v dobře větraných prostorách',
        S52: 'S52 - Nedoporučuje se pro použití v interiéru na velké plochy',
        S53: 'S53 - Zamezte expozici - před použitím si obstarejte speciální instrukce',
        S56:
          'S56 - Zneškodněte tento materiál a jeho obal ve sběrném místě pro zvláštní nebo nebezpečné odpady',
        S57: 'S57 - Použijte vhodný obal k zamezení kontaminace životního prostředí',
        S59: 'S59 - Informujte se u výrobce nebo dodavatele o regeneraci nebo recyklaci',
        S60: 'S60 - Tento materiál a jeho obal musí být zneškodněny jako nebezpečný odpad',
        S61:
          'S61 - Zabraňte uvolnění do životního prostředí. Viz speciální pokyny nebo bezpečnostní listy',
        S62:
          'S62 - Při požití nevyvolávejte zvracení: okamžitě vyhledejte lékařskou pomoc a ukažte tento obal nebo označení',
        S63:
          'S63 - V případě nehody při vdechnutí přeneste postiženého na čerstvý vzduch a ponechte jej v klidu',
        S64:
          'S64 - Při požití vypláchněte ústa velký množstvím vody (pouze je-li postižený při vědomí)',
        'S1/2': 'S1/2 - Uchovávejte uzamčené a mimo dosah dětí',
        'S3/7': 'S3/7 - Uchovávejte obal těsně uzavřený na chladném místě',
        'S3/9/14':
          'S3/9/14 - Uchovávejte na chladném, dobře větraném místě odděleně od ….. (vzájemně se vylučující látky uvede výrobce)',
        'S3/9/49':
          'S3/9/49 - Uchovávejte pouze v původním obalu na chladném dobře větraném místě, odděleně od ….. (vzájemně se vylučující látky uvede výrobce )',
        'S3/9/14/49':
          'S3/9/14/49 - Uchovávejte pouze v původním obalu na chladném, dobře větraném místě',
        'S3/14':
          'S3/14 - Uchovávejte na chladném místě, odděleně od (vzájemně se vylučující látky uvede výrobce)',
        'S7/8': 'S7/8 - Uchovávejte obal těsně uzavřený a suchý',
        'S7/9': 'S7/9 - Uchovávejte obal těsně uzavřený, na dobře větraném místě',
        'S7/49':
          'S7/47 - Uchovávejte obal těsně uzavřený, při teplotě nepřesahující ….. °C (specifikuje výrobce)',
        'S20/21': '20/21 - Nejezte, nepijte a nekuřte při používání',
        'S24/25': 'S24/25 - Zamezte styku s kůží a očima',
        'S27/28':
          'S27/28 - Po styku s kůží okamžitě odložte veškeré kontaminované oblečení a kůži okamžitě omyjte velkým množstvím ….. (vhodnou kapalinu specifikuje výrobce )',
        'S29/35':
          'S29/35 - Nevylévejte do kanalizace, tento materiál a jeho obal musí být zneškodněny bezpečným způsobem',
        'S29/56':
          'S29/56 - Nevylévejte do kanalizace, zneškodněte tento materiál a jeho obal ve sběrném místě pro zvláštní nebo nebezpečné odpady',
        'S36/37': 'S36/37 - Používejte vhodný ochranný oděv a ochranné rukavice.',
        'S36/39': 'S36/39 - Používejte vhodný ochranný oděv a ochranné brýle nebo obličejový štít.',
        'S37/39':
          'S37/39 - Používejte vhodné ochranné rukavice a ochranné brýle nebo obličejový štít.',
        'S36/37/39':
          'S36/37/39 - Používejte vhodný ochranný oděv, ochranné rukavice a ochranné brýle nebo obličejový štít.',
        'S47/49':
          'S47/49 - Uchovávejte pouze v původním obalu při teplotě nepřesahující … oC (specifikuje výrobce)'
      }
    },
    pagination: {
      first: 'První',
      previous: 'Předchozí',
      previous_arrow: '« Předchozí',
      next: 'Další',
      next_arrow: 'Další »',
      last: 'Poslední'
    },
    passwords: {
      reset: 'Heslo bylo obnoveno!',
      sent: 'E-mail s instrukcemi k obnovení hesla byl odeslán!',
      throttled: 'Please wait before retrying.',
      token: 'Klíč pro obnovu hesla je nesprávný.',
      user: 'Nepodařilo se najít uživatele s touto e-mailovou adresou.',
      no_account: 'Nemáte účet? Registrujte se!',
      has_account: 'Máte účet? Přihlásit se!',
      _: 'Heslo',
      current: 'Současné heslo',
      'no-match': 'Současné heslo bylo špatně zadáno!',
      new: 'Nové heslo',
      confirmation: 'Potvrzení hesla',
      change: 'Změna hesla',
      changed: 'Heslo bylo změněno',
      forbidden: 'Zakázané výrazy: {expressions} nebo části vašeho jména',
      forgot: {
        _: 'Zapomněli jste heslo?',
        title: 'Obnovení hesla',
        send: 'Obnovit heslo',
        sent: 'Odkaz pro obnovení hesla byl odeslán na zadanou adresu.'
      }
    },
    permissions: {
      title: 'Oprávnění',
      index: 'Oprávnění',
      show: 'Detail oprávnění',
      new: 'Nové oprávnění',
      create: 'Přidat oprávnění',
      edit: 'Upravit oprávnění',
      delete: 'Odstranit oprávnění',
      roles: 'Přiřazené role',
      'roles.none': 'Žádná role není přiřazena',
      msg: {
        'delete-disabled': 'Mazání oprávnění je dočasně deaktivováno.'
      }
    },
    profile: {
      index: 'Profil uživatele',
      profile: 'Můj profil',
      settings: {
        _: 'Nastavení',
        general: 'Obecné',
        lang: 'Jazyk',
        langs: {
          cs: 'Čeština',
          en: 'Angličtina'
        },
        listing: 'Počet položek na stránku',
        saved: 'Nastavení bylo uloženo.'
      },
      socials: {
        _: 'Sociální sítě',
        unlink: 'Odpojit účet'
      },
      msg: {
        social_unlink: 'Opravdu chcete odpojit sociální účet {name}?',
        social_unlinked: 'Sociální účet {name} byl odpojen.'
      }
    },
    roles: {
      title: 'Role',
      index: 'Role',
      show: 'Detail role',
      new: 'Nová role',
      create: 'Přidat roli',
      edit: 'Upravit roli',
      delete: 'Odstranit roli',
      none: 'Žádná role',
      permissions: {
        none: 'Žádné oprávnění není přiděleno',
        assigned: 'Přiřazená oprávnění',
        'not-assigned': 'Dostupná oprávnění k přiřazení',
        header: 'Nejdříve vytvoře roli, než začnete přidělovat oprávnění.'
      },
      users: {
        assigned: 'Uživatelé s rolí',
        none: 'Žádný uživatel nemá přiřazenou tuto roli'
      },
      msg: {
        'delete-disabled': 'Mazání rolí je dočasně deaktivováno.'
      }
    },
    stores: {
      title: 'Sklad',
      index: 'Sklady',
      all: 'Všechny sklady',
      show: 'Detail skladu',
      new: 'Nový sklad',
      create: 'Přidat sklad',
      edit: 'Upravit sklad',
      delete: 'Odstranit sklad',
      select: 'Vyber sklad',
      name: 'Název',
      abbr_name: 'Zkratka',
      tree_name: 'Celý název',
      parent: 'Nadřazený sklad',
      team: 'Tým skladu',
      children: 'Obsahuje sklady',
      temp: {
        _: 'Teplota',
        int: 'od {min} do {max} °C',
        min: 'Minimální',
        max: 'Maximální'
      },
      chemicals: 'Uložené chemikálie',
      msg: {
        has_items: 'Sklad {name} obsahuje chemikálie, nejprve je přesuňte nebo odstraňte.',
        has_children:
          'Sklad {name} obsahuje další sklady pod sebou, nejprve přesuňte tyto sklady mimo daný sklad.',
        name: 'Sklad s daným jménem již existuje v dané podskupině skladů.',
        is_child_or_self: 'Sklad nemůže být přesunut do vlastního dceřinného skladu.'
      }
    },
    tasks: {
      title: 'Úkol',
      index: 'Úkoly',
      cache: {
        _: 'Dočasné soubory',
        data: {
          _: 'Cached data',
          description: 'Delete temporary application cache data.',
          done: 'Temporary application data has been cleared.'
        },
        sessions: {
          _: 'Cached sessions',
          description: 'Delete session data.',
          done: 'Session files have been cleared.'
        },
        views: {
          _: 'Cached views',
          description: 'Delete cached views.',
          done: 'Cache views have been cleared.'
        }
      }
    },
    teams: {
      title: 'Tým',
      index: 'Týmy',
      show: 'Detail týmu',
      new: 'Nová tým',
      create: 'Přidat tým',
      edit: 'Upravit tým',
      delete: 'Odstranit tým',
      name: 'Název',
      'name.internal': 'Vnitřní název',
      stores: {
        _: 'Sklady s oprávněním',
        assigned: 'Sklady, které může tým upravovat',
        none: 'Žádné sklady nejsou přířazeny k týmu.'
      },
      msg: {
        has_items: 'Tým má přiřazené sklady, nejprvy zrušte přiřazení.'
      }
    },
    users: {
      title: 'Uživatel',
      index: 'Uživatelé',
      all: 'Všichni uživatelé',
      show: 'Detail uživatele',
      new: 'Nový uživatel',
      create: 'Přidat uživatele',
      edit: 'Upravit uživatele',
      delete: 'Odstranit uživatele',
      guest: 'Host',
      details: 'Podrobnosti',
      name: 'Jméno',
      email: 'Email',
      phone: 'Telefon',
      password: {
        _: 'Heslo',
        current: 'Současné heslo',
        'no-match': 'Současné heslo bylo špatně zadáno!',
        new: 'Nové heslo',
        confirmation: 'Potvrzení hesla',
        forbidden: 'Zakázané výrazy: {expressions} nebo části vašeho jména',
        forgot: 'Zapomněli jste vaše heslo?',
        change: 'Změnit heslo',
        changed: 'Heslo bylo změněno',
        reset: {
          _: 'Obnovení hesla',
          send: 'Obnovit heslo',
          sent: 'Odkaz pro obnovení hesla byl odeslán na zadanou adresu.'
        }
      },
      remember: 'Pamatuj mě',
      roles: {
        none: 'Žádná role není přiřazena tomuto uživateli',
        assigned: 'Role aktuálně přiřazené uživateli',
        'not-assigned': 'Role možné k přiřazení',
        header: 'Nejdřívě vytvořte uživatele k přiřazení rolí'
      }
    },
    validation: {
      accepted: 'Pole {attribute} musí být přijato.',
      active_url: 'Pole {attribute} není platnou URL adresou.',
      after: 'Pole {attribute} musí být datum po {date}.',
      after_or_equal: 'The {attribute} must be a date after or equal to {date}.',
      alpha: 'Pole {attribute} může obsahovat pouze písmena.',
      alpha_dash:
        'Pole {attribute} může obsahovat pouze písmena, číslice, pomlčky a podtržítka. České znaky (á, é, í, ó, ú, ů, ž, š, č, ř, ď, ť, ň) nejsou podporovány.',
      alpha_num: 'Pole {attribute} může obsahovat pouze písmena a číslice.',
      array: 'Pole {attribute} musí být pole.',
      before: 'Pole {attribute} musí být datum před {date}.',
      before_or_equal: 'The {attribute} must be a date before or equal to {date}.',
      between: {
        numeric: 'Pole {attribute} musí být hodnota mezi {min} a {max}.',
        file: 'Pole {attribute} musí být větší než {min} a menší než {max} Kilobytů.',
        string: 'Pole {attribute} musí být delší než {min} a kratší než {max} znaků.',
        array:
          'Pole {attribute} musí obsahovat nejméně {min} a nesmí obsahovat více než {max} prvků.'
      },
      boolean: 'Pole {attribute} musí být true (ano) nebo false (ne).',
      confirmed: 'Pole {attribute} se neshoduje / nebylo odsouhlaseno.',
      date: 'Pole {attribute} musí být platné datum.',
      date_format: 'Pole {attribute} není platný formát data podle {format}.',
      different: 'Pole {attribute} a {other} se musí lišit.',
      digits: 'Pole {attribute} musí být {digits} pozic dlouhé.',
      digits_between: 'Pole {attribute} musí být dlouhé nejméně {min} a nejvíce {max} pozic.',
      dimensions: 'Pole {attribute} má neplatné rozměry.',
      distinct: 'Pole {attribute} má duplicitní hodnotu.',
      email: 'Pole {attribute} není platný formát.',
      ends_with: 'Pole {attribute} musí končit jedním z následujích řetězeců znaků: {values}',
      exists: 'Zvolená hodnota pro {attribute} není platná.',
      file: 'Pole {attribute} musí být soubor.',
      filled: 'Pole {attribute} musí být vyplněno.',
      gt: {
        numeric: 'The {attribute} must be greater than {value}.',
        file: 'The {attribute} must be greater than {value} kilobytes.',
        string: 'The {attribute} must be greater than {value} characters.',
        array: 'The {attribute} must have more than {value} items.'
      },
      gte: {
        numeric: 'The {attribute} must be greater than or equal {value}.',
        file: 'The {attribute} must be greater than or equal {value} kilobytes.',
        string: 'The {attribute} must be greater than or equal {value} characters.',
        array: 'The {attribute} must have {value} items or more.'
      },
      image: 'Pole {attribute} musí být obrázek.',
      in: 'Zvolená hodnota pro {attribute} je neplatná.',
      in_array: 'Pole {attribute} není obsažen v {other}.',
      integer: 'Pole {attribute} musí být celé číslo.',
      ip: 'Pole {attribute} musí být platnou IP adresou.',
      ipv4: 'Pole {attribute} musí být platnou IPv4 adresou.',
      ipv6: 'Pole {attribute} musí být platnou IPv6 adresou.',
      json: 'Pole {attribute} musí být platný JSON řetězec.',
      lt: {
        numeric: 'The {attribute} must be less than {value}.',
        file: 'The {attribute} must be less than {value} kilobytes.',
        string: 'The {attribute} must be less than {value} characters.',
        array: 'The {attribute} must have less than {value} items.'
      },
      lte: {
        numeric: 'The {attribute} must be less than or equal {value}.',
        file: 'The {attribute} must be less than or equal {value} kilobytes.',
        string: 'The {attribute} must be less than or equal {value} characters.',
        array: 'The {attribute} must not have more than {value} items.'
      },
      max: {
        numeric: 'Pole {attribute} musí být nižší než {max}.',
        file: 'Pole {attribute} musí být menší než {max} Kilobytů.',
        string: 'Pole {attribute} musí být kratší než {max} znaků.',
        array: 'Pole {attribute} nesmí obsahovat více než {max} prvků.'
      },
      mimes: 'Pole {attribute} musí být jeden z následujících datových typů {values}.',
      mimetypes: 'Pole {attribute} musí být jeden z následujících datových typů {values}.',
      min: {
        numeric: 'Pole {attribute} musí být větší než {min}.',
        file: 'Pole {attribute} musí být větší než {min} Kilobytů.',
        string: 'Pole {attribute} musí být delší než {min} znaků.',
        array: 'Pole {attribute} musí obsahovat více než {min} prvků.'
      },
      not_in: 'Zvolená hodnota pro {attribute} je neplatná.',
      not_regex: 'Formát pole {attribute} není platný.',
      numeric:
        'Pole {attribute} musí být číslo (pro desetinné číslo použijte tečku jako oddělovač).',
      password: 'Heslo není správně zadáno.',
      phone: 'Pole {attribute} není platné telefonní číslo.',
      present: 'Pole {attribute} musí být vyplněno.',
      regex: 'Pole {attribute} nemá správný formát.',
      required: 'Pole {attribute} musí být vyplněno.',
      required_if: 'Pole {attribute} musí být vyplněno pokud {other} je {value}.',
      required_unless: 'Pole {attribute} musí být vyplněno dokud {other} je v {values}.',
      required_with: 'Pole {attribute} musí být vyplněno pokud {values} je vyplněno.',
      required_with_all: 'Pole {attribute} musí být vyplněno pokud {values} je zvoleno.',
      required_without: 'Pole {attribute} musí být vyplněno pokud {values} není vyplněno.',
      required_without_all:
        'Pole {attribute} musí být vyplněno pokud není žádné z {values} zvoleno.',
      same: 'Pole {attribute} a {other} se musí shodovat.',
      size: {
        numeric: 'Pole {attribute} musí být přesně {size}.',
        file: 'Pole {attribute} musí mít přesně {size} Kilobytů.',
        string: 'Pole {attribute} musí být přesně {size} znaků dlouhý.',
        array: 'Pole {attribute} musí obsahovat právě {size} prvků.'
      },
      starts_with: 'Pole {attribute} musí začínat jedním z následujích řetězeců znaků: {values}',
      string: 'Pole {attribute} musí být řetězec znaků.',
      timezone: 'Pole {attribute} musí být platná časová zóna.',
      unique: 'Pole {attribute} musí být unikátní.',
      uploaded: 'Nahrávání {attribute} se nezdařilo.',
      url: 'Formát {attribute} je neplatný.',
      uuid: 'Pole {attribute} musí být platné UUID.',
      custom: {
        recaptcha: {
          required: 'ReCaptcha nebyla správně vyplněna.'
        },
        password: {
          allowed: 'Heslo obsahuje nepovolené výrazy: {attribute}.'
        }
      },
      attributes: {
        name: 'jméno',
        surname: 'přijmení',
        password: 'heslo',
        password_current: 'současné heslo',
        email: 'email',
        phone: 'telefon'
      }
    }
  },
  en: {
    admin: {
      title: 'Administration',
      index: 'Administration'
    },
    audits: {
      title: 'Audit',
      index: 'Audits',
      show: 'Audit detail',
      new: 'New audit',
      create: 'Add audit',
      edit: 'Edit audit',
      delete: 'Delete audit',
      deleted: 'Deleted ({id})',
      type: 'Record type',
      name: 'Name/ID',
      event: 'Event',
      meta: {
        attribute: 'Attribute',
        event: 'Event',
        id: 'ID',
        ip_address: 'IP Address',
        user_agent: 'User Agent',
        new: 'New',
        old: 'Old',
        url: 'URL',
        user: 'User',
        tags: 'Tags'
      }
    },
    auth: {
      failed: 'These credentials do not match our records.',
      throttle: 'Too many login attempts. Please try again in {seconds} seconds.',
      verify: {
        _: 'Verify Your Email Address',
        confirm: 'Before proceeding, please check your email for a verification link.',
        resent: 'A fresh verification link has been sent to your email address.',
        resend_1: 'If you did not receive the email, you can request another one.',
        resend_2: 'Request new verification email'
      }
    },
    backups: {
      title: 'Database backups',
      index: 'Database backups',
      show: 'Download backup',
      new: 'New backup',
      create: 'Create backup',
      delete: 'Delete backup',
      none: 'No database has been found.'
    },
    brands: {
      title: 'Brand',
      index: 'Brands',
      show: 'Brand details',
      new: 'New brand',
      create: 'Add brand',
      edit: 'Edit brand',
      delete: 'Delete brand',
      url: {
        product: 'Product URL',
        sds: 'SDS File URL'
      },
      parse_callback: 'Parse Callback'
    },
    chemicals: {
      title: 'Chemical',
      index: 'Chemicals',
      show: 'Chemical details',
      new: 'New chemical',
      create: 'Add chemical',
      edit: 'Edit chemical',
      delete: 'Delete chemical',
      search: {
        group: 'Group by vendor',
        recent: 'Recently added chemicals'
      },
      name: 'Name',
      synonym: 'Synonym',
      iupac: 'IUPAC',
      brand: {
        _: 'Brand',
        id: 'Brand ID',
        error: 'Chemical with Vendor ID already exists.'
      },
      cas: 'CAS',
      mw: 'Molecular Weight',
      formula: 'Chemical Formula',
      pubchem: {
        _: 'PubChem',
        url: 'https://pubchem.ncbi.nlm.nih.gov/substance/{id}'
      },
      chemspider: {
        _: 'ChemSpider',
        url: 'https://www.chemspider.com/Chemical-Structure.{id}.html'
      },
      amount: 'Amount',
      unit: 'pcs',
      owner: 'Owner',
      'header.save': 'Firstly, save the header information!',
      structure: {
        _: 'Chemical structure',
        edit: 'Edit structure',
        draw: 'Draw structure',
        inchikey: 'InChI Key',
        inchi: 'InChI',
        sdf: 'SDF',
        smiles: 'Smiles',
        not: {
          entered: 'No chemical structure entereted.',
          resolved: "Chemical structure couldn't be resolved."
        }
      },
      data: {
        _: 'Get data',
        source: 'Zdroj',
        id: 'Indetifier',
        results: 'Results',
        all: 'Get all data (SA + Cactus)',
        cactus: {
          _: 'Cactus NCI data',
          hint:
            'Use chemical identifier (CAS, name, IUPAC, PubChem) to fetch data from Cactus NCI service.',
          'not-found': "'{label}' not found for '{search}'."
        },
        sigma: {
          _: 'Sigma Aldrich data',
          hint: 'Use product code to fetch data from vendor source.',
          'not-found': "Product not found for '{search}'."
        },
        vendor: {
          _: 'Vendor data',
          hint: 'Use product code to fetch data from vendor source.',
          'not-found': "Product not found for '{search}'."
        }
      },
      items: {
        _: 'Chemical Item',
        index: 'Chemicals items in stock',
        none: 'No chemical items in stock',
        create: 'Add Chemical Item',
        move: {
          _: 'Move selected',
          title: 'Move selected chemical item to store',
          number: 'Number of selected chemical items to relocate:'
        },
        'msg.moved': 'Selected chemicals have been moved.'
      },
      errors: {
        store: "You don't have permission to modify some of items in selected store."
      }
    },
    common: {
      index: 'ChemLab',
      chemlab: 'ChemLab',
      home: 'Homepage',
      register: 'Registration',
      login: 'Sign in',
      login_with: 'Sing in with {provider}',
      logout: 'Sign out',
      profile: 'Profile',
      other: 'Other',
      top: 'Back to top',
      link: {
        _: 'Link',
        public: 'Public link',
        external: 'External link'
      },
      social: {
        facebook: 'Facebook',
        linkedin: 'LinkedIn',
        rss: 'RSS',
        twitter: 'Twitter',
        youtube: 'Youtube'
      },
      admin: 'Administration',
      lab: 'Laboratory',
      acl: 'Access management',
      advanced: 'Advanced settings',
      misc: 'Miscellaneous',
      info: 'Information',
      options: 'Options',
      type: 'Type',
      category: 'Category',
      all: 'All',
      none: 'None',
      select: {
        _: 'Select',
        all: 'Select all',
        none: 'Select none'
      },
      not: {
        assigned: 'Not assigned',
        available: 'Not available',
        defined: 'Not defined',
        selected: 'Not selected',
        entered: 'Not entered',
        limited: 'Not limited',
        restricted: 'Not restricted'
      },
      error: 'Something went wrong!',
      'error.not-allowed': 'Not allowed action!',
      yes: 'Yes',
      true: 'Yes',
      no: 'No',
      false: 'No',
      add: 'Add',
      cancel: 'Cancel',
      close: 'Close',
      open: 'Open',
      remove: 'Remove',
      submit: 'Submit',
      save: 'Save',
      upload: 'Upload',
      send: 'Send',
      search: {
        title: 'Search',
        filter: 'Filter',
        clear: 'Clear filter',
        advanced: 'Advanced search options',
        trashed: 'Include trashed records'
      },
      filter: {
        role: 'Role',
        store: 'Store'
      },
      action: {
        _: 'Action',
        audit: 'Audit',
        back: 'Back',
        clear: 'Clear',
        create: 'Add',
        detail: 'Detail',
        download: 'Download',
        export: 'Export',
        insert: 'Insert',
        load: 'Load',
        structure: 'Structure',
        show: 'Info',
        submit: 'Submit',
        transfer: 'Transfer',
        print: 'Print',
        edit: 'Edit',
        delete: 'Delete',
        restore: 'Restore',
        destroy: 'Permanently delete',
        multi: {
          delete: 'Delete selected items',
          restore: 'Restore selected items'
        },
        confirm: {
          delete: 'Do you really want to delete {name}?',
          multi: {
            delete: 'Selected items will be deleted: '
          }
        }
      },
      exports: {
        print: 'Print',
        csv: 'CSV',
        excel: 'Excel'
      },
      record: {
        title: 'Record',
        type: 'Type of record',
        name: 'Name of record'
      },
      records: {
        count: 'Records count',
        selected: 'Records selected'
      },
      name: 'Name',
      surname: 'Surname',
      id: 'ID',
      title: 'Title',
      title_internal: 'Internal title',
      email: 'Email',
      subject: 'Subject',
      content: 'Content',
      message: 'Message',
      text: 'Content',
      description: 'Description',
      notes: 'Notes',
      size: 'Size',
      count: 'Count',
      date: 'Date',
      available_at: 'Available at',
      expires_at: 'Expiry date',
      expired_at: 'Expired at',
      created_at: 'Created at',
      updated_at: 'Updated at',
      deleted_at: 'Deleted at',
      year: 'Year',
      terms: {
        consent: 'I agree with processing of ',
        privacy: 'provided personal data.'
      },
      oauth2: {
        missing_email:
          'You have provide valid email address in order pro login/register via 3rd party provider.'
      },
      msg: {
        stored: 'Record ({name}) has been stored.',
        updated: 'Record ({name}) has been updated.',
        deleted: 'Record ({name}) has been deleted.',
        transferred: 'Record ({name}) has been moved.',
        multi: {
          deleted: 'Selected items were deleted.'
        },
        registered:
          'You have been successfully registered. We have sent you instruction how to fully activate your account.'
      }
    },
    jobs: {
      title: 'Jobs',
      index: 'Jobs',
      show: 'Show job',
      run: 'Run job',
      delete: 'Delete job',
      none: 'No job has been found.',
      queue: 'Queue',
      attempts: 'Attempts'
    },
    logs: {
      title: 'Log',
      index: 'Logs',
      show: 'Show log',
      delete: 'Delete log',
      none: 'No log has been found.'
    },
    mail: {
      greeting: 'Hello',
      salutation: 'Regards',
      subcopy:
        'If you’re having trouble clicking the "{action}" button, copy and paste the URL below into your web browser',
      'password.new.subject': 'Set your password for new account',
      'password.new.notify':
        'New account has been created for you. Please set your new password with following link.',
      'password.new.notify.error':
        'If you think that account has been created by mistake, please contact us to confirm or just ignore the email.',
      'password.reset.subject': 'Reset your password',
      'password.reset.notify':
        'You are receiving this email because we received a password reset request for your account.',
      'password.reset.notify.error':
        'If you did not request a password reset, no further action is required.',
      'password.reset.expire': 'This password reset link will expire in {count} minutes.',
      'email.verify.subject': 'Verify Email Address',
      'email.verify.action': 'Verify Email Address',
      'email.verify.notify': 'Please click the button below to verify your email address.',
      'email.verify.notify.error':
        'If you did not create an account, no further action is required.'
    },
    msds: {
      title: 'Safety information',
      sds: {
        _: 'Safety Data Sheet',
        get: 'Download',
        'not-found': 'No SDS file upload yet.',
        vendor: "Vendor's website"
      },
      symbol: 'Pictogram',
      signal_word: 'Signal word',
      h_title: 'Hazard statements',
      h_abbr: 'H-statements',
      p_title: 'Precautionary statements',
      p_abbr: 'P-statements',
      r_title: 'Risk phrases',
      r_abbr: 'R-phrases',
      s_title: 'Safety phrases',
      s_abbr: 'S-phrases',
      symbols: {
        GHS01: 'GHS01 - Exploding bomb',
        GHS02: 'GHS02 - Flame',
        GHS03: 'GHS03 - Flame over circle',
        GHS04: 'GHS04 - Gas cylinder',
        GHS05: 'GHS05 - Corrosion',
        GHS06: 'GHS06 - Skull and crossbones',
        GHS07: 'GHS07 - Exclamation mark',
        GHS08: 'GHS08 - Health hazard',
        GHS09: 'GHS09 - Environment'
      },
      h: {
        H200: 'H200 - Unstable explosives.',
        H201: 'H201 - Explosive, mass explosion hazard.',
        H202: 'H202 - Explosive, severe projection hazard.',
        H203: 'H203 - Explosive, fire, blast or projection hazard.',
        H204: 'H204 - Fire or projection hazard.',
        H205: 'H205 - May mass explode in fire.',
        H220: 'H220 - Extremely flammable gas.',
        H221: 'H221 - Flammable gas.',
        H222: 'H222 - Extremely flammable aerosol.',
        H223: 'H223 - Flammable aerosol.',
        H224: 'H224 - Extremely flammable liquid and vapour.',
        H225: 'H225 - Highly flammable liquid and vapour.',
        H226: 'H226 - Flammable liquid and vapour.',
        H228: 'H228 - Flammable solid.',
        H240: 'H240 - Heating may cause an explosion.',
        H241: 'H241 - Heating may cause a fire or explosion.',
        H242: 'H242 - Heating may cause a fire.',
        H250: 'H250 - Catches fire spontaneously if exposed to air.',
        H251: 'H251 - Self-heating: may catch fire.',
        H252: 'H252 - Self-heating in large quantities; may catch fire.',
        H260:
          'H260 - In contact with water releases flammable gases which may ignite spontaneously.',
        H261: 'H261 - In contact with water releases flammable gases.',
        H270: 'H270 - May cause or intensify fire; oxidiser.',
        H271: 'H271 - May cause fire or explosion; strong oxidiser.',
        H272: 'H272 - May intensify fire; oxidiser.',
        H280: 'H280 - Contains gas under pressure; may explode if heated.',
        H281: 'H281 - Contains refrigerated gas; may cause cryogenic burns or injury.',
        H290: 'H290 - May be corrosive to metals.',
        H300: 'H300 - Fatal if swallowed.',
        H301: 'H301 - Toxic if swallowed.',
        H302: 'H302 - Harmful if swallowed.',
        H304: 'H304 - May be fatal if swallowed and enters airways.',
        H310: 'H310 - Fatal in contact with skin.',
        H311: 'H311 - Toxic in contact with skin.',
        H312: 'H312 - Harmful in contact with skin.',
        H314: 'H314 - Causes severe skin burns and eye damage.',
        H315: 'H315 - Causes skin irritation.',
        H317: 'H317 - May cause an allergic skin reaction.',
        H318: 'H318 - Causes serious eye damage.',
        H319: 'H319 - Causes serious eye irritation.',
        H330: 'H330 - Fatal if inhaled.',
        H331: 'H331 - Toxic if inhaled.',
        H332: 'H332 - Harmful if inhaled.',
        H334: 'H334 - May cause allergy or asthma symptoms or breathing difficulties if inhaled.',
        H335: 'H335 - May cause respiratory irritation.',
        H336: 'H336 - May cause drowsiness or dizziness.',
        H340: 'H340 - May cause genetic defects, exposure cause the hazard.',
        H341: 'H341 - Suspected of causing genetic defects.',
        H350: 'H350 - May cause cancer.',
        H351: 'H351 - Suspected of causing cancer.',
        H360: 'H360 - May damage fertility or the unborn child.',
        H361: 'H361 - Suspected of damaging fertility or the unborn child.',
        H362: 'H362 - May cause harm to breast-fed children.',
        H370: 'H370 - Causes damage to organs.',
        H371: 'H371 - May cause damage to organs.',
        H372:
          'H372 - Causes damage to organs through prolonged or repeated exposure exposure cause the hazard.',
        H373:
          'H373 - May cause damage to organs through prolonged or repeated exposure exposure cause the hazard.',
        H400: 'H400 - Very toxic to aquatic life.',
        H410: 'H410 - Very toxic to aquatic life with long lasting effects.',
        H411: 'H411 - Toxic to aquatic life with long lasting effects.',
        H412: 'H412 - Harmful to aquatic life with long lasting effects.',
        H413: 'H413 - May cause long lasting harmful effects to aquatic life.',
        'H300+H310': 'H300+H310 - Fatal if swallowed or in contact with skin.',
        'H300+H330': 'H300+H330 - Fatal if swallowed or inhaled.',
        'H310+H330': 'H310+H330 - Fatal if in contact with skin or inhaled.',
        'H300+H310+H330': 'H300+H310+H330 - Fatal if swallowed, in contact with skin or inhaled.',
        'H301+H311': 'H301+H311 - Toxic if swallowed or in contact with skin.',
        'H301+H331': 'H301+H331 - Toxic if swallowed or inhaled.',
        'H311+H331': 'H311+H331 - Toxic if in contact with skin or inhaled.',
        'H301+H311+H331': 'H301+H311+H331 - Toxic if swallowed, in contact with skin or inhaled.',
        'H302+H312': 'H302+H312 - Harmful if swallowed or in contact with skin.',
        'H302+H332': 'H302+H332 - Harmful if swallowed or inhaled.',
        'H312+H332': 'H312+H332 - Harmful if in contact with skin or inhaled.',
        'H302+H312+H332': 'H302+H312+H332 - Harmful if swallowed, in contact with skin or inhaled.',
        EUH001: 'EUH001 – Explosive when dry.',
        EUH006: 'EUH006 – Explosive with or without contact with air.',
        EUH014: 'EUH014 – Reacts violently with water.',
        EUH018: 'EUH018 – In use, may form flammable/explosive vapour-air mixture.',
        EUH019: 'EUH019 – May form explosive peroxides.',
        EUH044: 'EUH044 – Risk of explosion if heated under confinement.',
        EUH029: 'EUH029 – Contact with water liberates toxic gas.',
        EUH031: 'EUH031 – Contact with acids liberates toxic gas.',
        EUH032: 'EUH032 – Contact with acids liberates very toxic gas.',
        EUH066: 'EUH066 – Repeated exposure may cause skin dryness or cracking.',
        EUH070: 'EUH070 – Toxic by eye contact.',
        EUH071: 'EUH071 – Corrosive to the respiratory tract.',
        EUH059: 'EUH059 – Hazardous to the ozone layer.',
        EUH201:
          'EUH201 – Contains lead. Should not be used on surfaces liable to be chewed or sucked by children.',
        EUH201A: 'EUH201A – Warning! Contains lead.',
        EUH202:
          'EUH202 – Cyanoacrylate. Danger. Bonds skin and eyes in seconds. Keep out of the reach of children.',
        EUH203: 'EUH203 – Contains chromium (VI). May produce an allergic reaction.',
        EUH204: 'EUH204 – Contains isocyanates. May produce an allergic reaction.',
        EUH205: 'EUH205 – Contains epoxy constituents. May produce an allergic reaction.',
        EUH206:
          'EUH206 – Warning! Do not use together with other products. May release dangerous gases (chlorine)',
        EUH207:
          'EUH207 – Warning! Contains cadmium. Dangerous fumes are formed during use. See information supplied by the manufacturer. Comply with the safety instructions.',
        EUH208:
          'EUH208 – Contains (name of sensitising substance). May produce an allergic reaction.',
        EUH209: 'EUH209 – Can become highly flammable in use.',
        EUH209A: 'EUH209A – Can become flammable in use.',
        EUH210: 'EUH210 – Safety data sheet available on request.',
        EUH401:
          'EUH401 – To avoid risks to human health and the environment, comply with the instructions for use.'
      },
      p: {
        P101: 'P101 - If medical advice is needed, have product container or label at hand.',
        P102: 'P102 - Keep out of reach of children.',
        P103: 'P103 - Read label before use.',
        P201: 'P201 - Obtain special instructions before use.',
        P202: 'P202 - Do not handle until all safety precautions have been read and understood.',
        P210: 'P210 - Keep away from heat/sparks/open flames/hot surfaces. — No smoking.',
        P211: 'P211 - Do not spray on an open flame or other ignition source.',
        P220: 'P220 - Keep/Store away from clothing/…/combustible materials.',
        P221: 'P221 - Take any precaution to avoid mixing with combustibles…',
        P222: 'P222 - Do not allow contact with air.',
        P223:
          'P223 - Keep away from any possible contact with water, because of violent reaction and possible flash fire.',
        P230: 'P230 - Keep wetted with…',
        P231: 'P231 - Handle under inert gas.',
        P232: 'P232 - Protect from moisture.',
        P233: 'P233 - Keep container tightly closed.',
        P234: 'P234 - Keep only in original container.',
        P235: 'P235 - Keep cool.',
        P240: 'P240 - Ground/bond container and receiving equipment.',
        P241: 'P241 - Use explosion-proof electrical/ventilating/lighting/…/equipment.',
        P242: 'P242 - Use only non-sparking tools.',
        P243: 'P243 - Take precautionary measures against static discharge.',
        P244: 'P244 - Keep reduction valves free from grease and oil.',
        P250: 'P250 - Do not subject to grinding/shock/…/friction.',
        P251: 'P251 - Pressurized container: Do not pierce or burn, even after use.',
        P260: 'P260 - Do not breathe dust/fume/gas/mist/vapours/spray.',
        P261: 'P261 - Avoid breathing dust/fume/gas/mist/vapours/spray.',
        P262: 'P262 - Do not get in eyes, on skin, or on clothing.',
        P263: 'P263 - Avoid contact during pregnancy/while nursing.',
        P264: 'P264 - Wash … thoroughly after handling.',
        P270: 'P270 - Do no eat, drink or smoke when using this product.',
        P271: 'P271 - Use only outdoors or in a well-ventilated area.',
        P272: 'P272 - Contaminated work clothing should not be allowed out of the workplace.',
        P273: 'P273 - Avoid release to the environment.',
        P280: 'P280 - Wear protective gloves/protective clothing/eye protection/face protection.',
        P281: 'P281 - Use personal protective equipment as required.',
        P282: 'P282 - Wear cold insulating gloves/face shield/eye protection.',
        P283: 'P283 - Wear fire/flame resistant/retardant clothing.',
        P284: 'P284 - Wear respiratory protection.',
        P285: 'P285 - In case of inadequate ventilation wear respiratory protection.',
        'P231+P232': '231+232 - Handle under inert gas. Protect from moisture.',
        'P235+P410': 'P235+P410 - Keep cool. Protect from sunlight.',
        P301: 'P301 - IF SWALLOWED:',
        P302: 'P302 - IF ON SKIN:',
        P303: 'P303 - IF ON SKIN (or hair):',
        P304: 'P304 - IF INHALED:',
        P305: 'P305 - IF IN EYES:',
        P306: 'P306 - IF ON CLOTHING:',
        P307: 'P307 - IF exposed:',
        P308: 'P308 - IF exposed or concerned:',
        P309: 'P309 - IF exposed or if you feel unwell:',
        P310: 'P310 - Immediately call a POISON CENTER or doctor/physician.',
        P311: 'P311 - Call a POISON CENTER or doctor/physician.',
        P312: 'P312 - Call a POISON CENTER or doctor/physician if you feel unwell.',
        P313: 'P313 - Get medical advice/attention.',
        P314: 'P314 - Get medical advice/attention if you feel unwell.',
        P315: 'P315 - Get immediate medical advice/attention.',
        P320: 'P320 - Specific treatment is urgent (see … on this label).',
        P321: 'P321 - Specific treatment (see … on this label).',
        P322: 'P322 - Specific measures (see … on this label).',
        P330: 'P330 - Rinse mouth.',
        P331: 'P331 - Do NOT induce vomiting.',
        P332: 'P332 - If skin irritation occurs:',
        P333: 'P333 - If skin irritation or rash occurs:',
        P334: 'P334 - Immerse in cool water/wrap in wet bandages.',
        P335: 'P335 - Brush off loose particles from skin.',
        P336: 'P336 - Thaw frosted parts with lukewarm water. Do no rub affected area.',
        P337: 'P337 - If eye irritation persists:',
        P338: 'P338 - Remove contact lenses, if present and easy to do. Continue rinsing.',
        P340:
          'P340 - Remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        P341:
          'P341 - If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        P342: 'P342 - If experiencing respiratory symptoms:',
        P350: 'P350 - Gently wash with plenty of soap and water.',
        P351: 'P351 - Rinse cautiously with water for several minutes.',
        P352: 'P352 - Wash with plenty of soap and water.',
        P353: 'P353 - Rinse skin with water/shower.',
        P360:
          'P360 - Rinse immediately contaminated clothing and skin with plenty of water before removing clothes.',
        P361: 'P361 - Remove/Take off immediately all contaminated clothing.',
        P362: 'P362 - Take off contaminated clothing and wash before reuse.',
        P363: 'P363 - Wash contaminated clothing before reuse.',
        P370: 'P370 - In case of fire:',
        P371: 'P371 - In case of major fire and large quantities:',
        P372: 'P372 - Explosion risk in case of fire.',
        P373: 'P373 - DO NOT fight fire when fire reaches explosives.',
        P374: 'P374 - Fight fire with normal precautions from a reasonable distance.',
        P375: 'P375 - Fight fire remotely due to the risk of explosion.',
        P376: 'P376 - Stop leak if safe to do so.',
        P377: 'P377 - Leaking gas fire: Do not extinguish, unless leak can be stopped safely.',
        P378: 'P378 - Use … for extinction.',
        P380: 'P380 - Evacuate area.',
        P381: 'P381 - Eliminate all ignition sources if safe to do so.',
        P390: 'P390 - Absorb spillage to prevent material damage.',
        P391: 'P391 - Collect spillage.',
        'P301+P310':
          'P301+P310 - IF SWALLOWED: Immediately call a POISON CENTER or doctor/physician.',
        'P301+P312':
          'P301+P312 - IF SWALLOWED: Call a POISON CENTER or doctor/physician if you feel unwell.',
        'P301+P330+P331': 'P301+P330+P331 - IF SWALLOWED: rinse mouth. Do NOT induce vomiting.',
        'P302+P334': 'P302+P334 - IF ON SKIN: Immerse in cool water/wrap in wet bandages.',
        'P302+P350': 'P302+P350 - IF ON SKIN: Gently wash with plenty of soap and water.',
        'P302+P352': 'P302+P353 - IF ON SKIN: Wash with plenty of soap and water.',
        'P303+P361+P353':
          'P303+P361+P353 - IF ON SKIN (or hair): Remove/Take off immediately all contaminated clothing. Rinse skin with water/shower.',
        'P304+P340':
          'P304+P340 - IF INHALED: Remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        'P304+P341':
          'P304+P341 - IF INHALED: If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.',
        'P305+P351+P338':
          'P305+P351+P338 - IF IN EYES: Rinse cautiously with water for several minutes. Remove contact lenses, if present and easy to do. Continue rinsing.',
        'P306+P360':
          'P306+P360 - IF ON CLOTHING: rinse immediately contaminated clothing and skin with plenty of water before removing clothes.',
        'P307+P311': 'P307+P311 - IF exposed: Call a POISON CENTER or doctor/physician.',
        'P308+P313': 'P308+P313 - IF exposed or concerned: Get medical advice/attention.',
        'P309+P311':
          'P309+P311 - IF exposed or if you feel unwell: Call a POISON CENTER or doctor/physician.',
        'P332+P313': 'P332+P313 - If skin irritation occurs: Get medical advice/attention.',
        'P333+P313': 'P333+P313 - If skin irritation or rash occurs: Get medical advice/attention.',
        'P335+P334':
          'P335+P334 - Brush off loose particles from skin. Immerse in cool water/wrap in wet bandages.',
        'P337+P313': 'P337+P313 - If eye irritation persists: Get medical advice/attention.',
        'P342+P311':
          'P342+P311 - If experiencing respiratory symptoms: Call a POISON CENTER or doctor/physician.',
        'P370+P376': 'P370+P376 - In case of fire: Stop leak if safe to do so.',
        'P370+P378': 'P370+P378 - In case of fire: Use … for extinction.',
        'P370+P380': 'P101 - In case of fire: Evacuate area.',
        'P370+P380+P375':
          'P370+P380+P375 - In case of fire: Evacuate area. Fight fire remotely due to the risk of explosion.',
        'P371+P380+P375':
          'P371+P380+P375 - In case of major fire and large quantities: Evacuate area. Fight fire remotely due to the risk of explosion.',
        P401: 'P401 - Store …',
        P402: 'P402 - Store in a dry place.',
        P403: 'P403 - Store in a well-ventilated place.',
        P404: 'P404 - Store in a closed container.',
        P405: 'P405 - Store locked up.',
        P406: 'P406 - Store in corrosive resistant/… container with a resistant inner liner.',
        P407: 'P407 - Maintain air gap between stacks/pallets.',
        P410: 'P410 - Protect from sunlight.',
        P411: 'P411 - Store at temperatures not exceeding … oC/…oF.',
        P412: 'P412 - Do not expose to temperatures exceeding 50 oC/122oF.',
        P413:
          'P413 - Store bulk masses greater than … kg/… lbs at temperatures not exceeding … oC/…oF.',
        P420: 'P420 - Store away from other materials.',
        P422: 'P422 - Store contents under …',
        'P402+P404': 'P402+P404 - Store in a dry place. Store in a closed container.',
        'P403+P233': 'P403+P233 - Store in a well-ventilated place. Keep container tightly closed.',
        'P403+P235': 'P403+P235 - Store in a well-ventilated place. Keep cool.',
        'P410+P403': 'P410+P403 - Protect from sunlight. Store in a well-ventilated place.',
        'P410+P412':
          'P410+P412 - Protect from sunlight. Do no expose to temperatures exceeding 50 oC/122oF.',
        'P411+P235': 'P411+P235 - Store at temperatures not exceeding … oC/…oF. Keep cool.',
        P501: 'P501 - Dispose of contents/container to …',
        P502: 'P502 - Refer to manufacturer/supplier for information on recovery/recycling'
      },
      r: {
        R1: 'R1 - Explosive when dry.',
        R2: 'R2 - Risk of explosion by shock, friction, fire or other sources of ignition.',
        R3: 'R3 - Extreme risk of explosion by shock, friction, fire or other sources of ignition.',
        R4: 'R4 - Forms very sensitive explosive metallic compounds.',
        R5: 'R5 - Heating may cause an explosion.',
        R6: 'R6 - Explosive with or without contact with air.',
        R7: 'R7 - May cause fire.',
        R8: 'R8 - Contact with combustible material may cause fire.',
        R9: 'R9 - Explosive when mixed with combustible material.',
        R10: 'R10 - Flammable.',
        R11: 'R11 - Highly flammable.',
        R12: 'R12 - Extremely flammable.',
        R14: 'R14 - Reacts violently with water.',
        R15: 'R15 - Contact with water liberates extremely flammable gases.',
        R16: 'R16 - Explosive when mixed with oxidizing substances.',
        R17: 'R17 - Spontaneously flammable in air.',
        R18: 'R18 - In use, may form flammable/explosive vapour-air mixture.',
        R19: 'R19 - May form explosive peroxides.',
        R20: 'R20 - Harmful by inhalation.',
        R21: 'R21 - Harmful in contact with skin.',
        R22: 'R22 - Harmful if swallowed.',
        R23: 'R23 - Toxic by inhalation.',
        R24: 'R24 - Toxic in contact with skin.',
        R25: 'R25 - Toxic if swallowed.',
        R26: 'R26 - Very toxic by inhalation.',
        R27: 'R27 - Very toxic in contact with skin.',
        R28: 'R28 - Very toxic if swallowed.',
        R29: 'R29 - Contact with water liberates toxic gas.',
        R30: 'R30 - Can become highly flammable in use.',
        R31: 'R31 - Contact with acids liberates toxic gas.',
        R32: 'R32 - Contact with acids liberates very toxic gas.',
        R33: 'R33 - Danger of cumulative effects.',
        R34: 'R34 - Causes burns.',
        R35: 'R35 - Causes severe burns.',
        R36: 'R36 - Irritating to eyes.',
        R37: 'R37 - Irritating to respiratory system.',
        R38: 'R38 - Irritating to skin.',
        R39: 'R39 - Danger of very serious irreversible effects.',
        R40: 'R40 - Limited evidence of a carcinogenic effect.',
        R41: 'R41 - Risk of serious damage to eyes.',
        R42: 'R42 - May cause sensitization by inhalation.',
        R43: 'R43 - May cause sensitisation by skin contact.',
        R44: 'R44 - Risk of explosion if heated under confinement.',
        R45: 'R45 - May cause cancer.',
        R46: 'R46 - May cause heritable genetic damage.',
        R48: 'R48 - Danger of serious damage to health by prolonged exposure.',
        R49: 'R49 - May cause cancer by inhalation.',
        R50: 'R50 - Very toxic to aquatic organisms.',
        R51: 'R51 - Toxic to aquatic organisms.',
        R52: 'R52 - Harmful to aquatic organisms.',
        R53: 'R53 - May cause long-term adverse effects in the aquatic environment.',
        R54: 'R54 - Toxic to flora.',
        R55: 'R55 - Toxic to fauna.',
        R56: 'R56 - Toxic to soil organisms.',
        R57: 'R57 - Toxic to bees.',
        R58: 'R58 - May cause long-term adverse effects in the environment.',
        R59: 'R59 - Dangerous for the ozone layer.',
        R60: 'R60 - May impair fertility.',
        R61: 'R61 - May cause harm to the unborn child.',
        R62: 'R62 - Possible risk of impaired fertility.',
        R63: 'R63 - Possible risk of harm to the unborn child.',
        R64: 'R64 - May cause harm to breastfed babies.',
        R65: 'R65 - Harmful: may cause lung damage if swallowed.',
        R66: 'R66 - Repeated exposure may cause skin dryness or cracking.',
        R67: 'R67 - Vapours may cause drowsiness and dizziness.',
        R68: 'R68 - Possible risk of irreversible effects.',
        'R14/15': 'R14/15 - Reacts violently with water, liberating extremely flammable gases.',
        'R15/29': 'R15/29 - Contact with water liberates toxic, extremely flammable gas.',
        'R20/21': 'R20/21 - Harmful by inhalation and in contact with skin.',
        'R20/22': 'R20/22 - Harmful by inhalation and if swallowed.',
        'R21/22': 'R21/22 - Harmful in contact with skin and if swallowed.',
        'R20/21/22': 'R20/21/22 - Harmful by inhalation, in contact with skin and if swallowed.',
        'R23/24': 'R23/24 - Toxic by inhalation and in contact with skin.',
        'R24/25': 'R24/25 - Toxic in contact with skin and if swallowed.',
        'R23/25': 'R23/25 - Toxic by inhalation and if swallowed.',
        'R23/24/25': 'R23/24/25 - Toxic by inhalation, in contact with skin and if swallowed.',
        'R26/27': 'R26/27 - Very toxic by inhalation and in contact with skin.',
        'R26/28': 'R26/28 - Very toxic by inhalation and if swallowed.',
        'R26/27/28': 'R26/27/28 - Very toxic by inhalation, in contact with skin and if swallowed.',
        'R27/28': 'R27/28 - Very toxic in contact with skin and if swallowed.',
        'R36/37': 'R36/37 - Irritating to eyes and respiratory system.',
        'R36/38': 'R36/38 - Irritating to eyes and skin.',
        'R37/38': 'R37/38 - Irritating to respiratory system and skin.',
        'R36/37/38': 'R36/37/38 - Irritating to eyes, respiratory system and skin.',
        'R39/23': '39/23 - Toxic: danger of very serious irreversible effects through inhalation.',
        'R39/24':
          '39/24 - Toxic: danger of very serious irreversible effects in contact with skin.',
        'R39/25': '39/25 - Toxic: danger of very serious irreversible effects if swallowed.',
        'R39/32/24':
          '39/32/24 - Toxic: danger of very serious irreversible effects through inhalation and in contact with skin.',
        'R39/23/25':
          '39/23/25 - Toxic: danger of very serious irreversible effects through inhalation and if swallowed.',
        'R39/24/25':
          '39/24/25 - Toxic: danger of very serious irreversible effects in contact with skin and if swallowed.',
        'R39/23/24/25':
          '39/23/24/25 - Toxic: danger of very serious irreversible effects through inhalation,  in contact with skin and if swallowed.',
        'R39/26':
          '39/26 - Very toxic: danger of very serious irreversible effects through inhalation.',
        'R39/26/27':
          '39/26/27 - Very toxic: danger of very serious irreversible effects through inhalation and in contact with skin.',
        'R39/27':
          '39/27 - Very toxic: danger of very serious irreversible effects in contact with skin.',
        'R39/28': 'R39/28 - Very toxic: danger of very serious irreversible effects if swallowed.',
        'R39/26/28':
          'R39/26/28 - Very toxic: danger of very serious irreversible effects through inhalation and if swallowed.',
        'R39/27/28':
          'R39/27/28 - Very toxic: danger of very serious irreversible effects in contact with skin and if swallowed.',
        'R39/26/27/28':
          'R39/26/27/28 - Very toxic: danger of very serious irreversible effects through inhalation, in contact with skin and if swallowed.',
        'R68/20': 'R68/20 - Harmful: possible risk of irreversible effects through inhalation.',
        'R68/21': 'R68/21 - Harmful: possible risk of irreversible effects in contact with skin.',
        'R68/22': 'R68/22 - Harmful: possible risk of irreversible effects if swallowed.',
        'R68/20/21':
          'R68/20/21 - Harmful: possible risk of irreversible effects through inhalation  and in contact with skin.',
        'R68/20/22':
          'R68/20/22 - Harmful: possible risk of irreversible effects through inhalation  and if swallowed.',
        'R68/21/22':
          'R68/21/22 - Harmful: possible risk of irreversible effects in contact with skin  and if swallowed.',
        'R68/20/21/22':
          'R68/20/21/22 - Harmful: possible risk of irreversible effects through inhalation,  in contact with skin and if swallowed.',
        'R42/43': 'R42/43 - May cause sensitization by inhalation and skin contact.',
        'R48/20':
          'R48/20 - Harmful: danger of serious damage to health by prolonged exposure through inhalation.',
        'R48/21':
          'R48/21 - Harmful: danger of serious damage to health by prolonged exposure in contact with skin.',
        'R48/22':
          'R48/22 - Harmful: danger of serious damage to health by prolonged exposure if swallowed.',
        'R48/20/21':
          'R48/20/21 - Harmful: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin.',
        'R48/20/22':
          'R48/20/22 - Harmful: danger of serious damage to health by prolonged exposure through inhalation and if swallowed.',
        'R48/21/22':
          'R48/21/22 - Harmful: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed.',
        'R48/20/21/22':
          'R48/20/21/22 - Harmful: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed.',
        'R48/23':
          'R48/23 -  Toxic: danger of serious damage to health by prolonged exposure through inhalation.',
        'R48/24':
          'R48/24 - Toxic: danger of serious damage to health by prolonged exposure in contact with skin.',
        'R48/25':
          'R48/25 - Toxic: danger of serious damage to health by prolonged exposure if swallowed.',
        'R48/23/24':
          'R48/23/24 - Toxic: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin.',
        'R48/23/25':
          'R48/23/25 - Toxic: danger of serious damage to health by prolonged exposure through inhalation and if swallowed.',
        'R48/24/25':
          'R48/24/25 - Toxic: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed.',
        'R48/23/24/25':
          'R48/23/24/25 - Toxic: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed.',
        'R50/53':
          'R50/53 - Very toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment.',
        'R51/53':
          'R51/53 - Toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment.',
        'R52/53':
          'R52/53 - Harmful to aquatic organisms, may cause long-term adverse effects in the aquatic environment.'
      },
      s: {
        S1: 'S1 - Keep locked up',
        S2: 'S2 - Keep out of the reach of children',
        S3: 'S3  - Keep in a cool place',
        S4: 'S4 - Keep away from living quarters',
        S5: 'S5 - Keep contents under ... (appropriate liquid to be specified by the manufacturer)',
        S6: 'S6 - Keep under ... (inert gas to be specified by the manufacturer)',
        S7: 'S7 - Keep container tightly closed',
        S8: 'S8 - Keep container dry',
        S9: 'S9 - Keep container in a well-ventilated place',
        S12: 'S12 - Do not keep the container sealed',
        S13: 'S13 - Keep away from food, drink and animal feedingstuffs',
        S14:
          'S14 - Keep away from ... (incompatible materials to be indicated by the manufacturer)',
        S15: 'S15 - Keep away from heat',
        S16: 'S16 - Keep away from sources of ignition – No smoking',
        S17: 'S17 - Keep away from combustible material',
        S18: 'S18 - Handle and open container with care',
        S20: 'S20 - When using do not eat or drink',
        S21: 'S21 - When using do not smoke',
        S22: 'S22 - Do not breathe dust',
        S23:
          'S23 - Do not breathe gas/fumes/vapour/spray (appropriate wording to be specified by the manufacturer)',
        S24: 'S24 - Avoid contact with skin',
        S25: 'S25 - Avoid contact with eyes',
        S26:
          'S26 - In case of contact with eyes, rinse immediately with plenty of water and seek medical advice',
        S27: 'S27 - Take off immediately all contaminated clothing',
        S28:
          'S28 - After contact with skin, wash immediately with plenty of (to be specified by the manufacturer)',
        S29: 'S29 - Do not empty into drains',
        S30: 'S30 - Never add water to this product',
        S33: 'S33 - Take precautionary measures against static discharges',
        S35: 'S35 - This material and its container must be disposed of in a safe way',
        S36: 'S36 - Wear suitable protective clothing',
        S37: 'S37 - Wear suitable gloves',
        S38: 'S38 - In case of insufficient ventilation wear suitable respiratory equipment',
        S39: 'S39 - Wear eye/face protection',
        S40:
          'S40 - To clean the floor and all objects contaminated by this material use ... (to be specified by the manufacturer)',
        S41: 'S41 - In case of fire and/or explosion do not breathe fumes',
        S42:
          'S42 - During fumigation/spraying wear suitable respiratory equipment (appropriate wording to be specified by the manufacturer)',
        S43:
          'S43 - In case of fire use ... (indicate in the space the precise type of fire-fighting equipment. If water increases the risk add: Never use water)',
        S45:
          'S45 - In case of accident or if you feel unwell seek medical advice immediately (show the label where possible)',
        S46: 'S46 - If swallowed, seek medical advice immediately and show this container or label',
        S47: 'S47 - Keep at temperature not exceeding ...°C (to be specified by the manufacturer)',
        S48:
          'S48 - Keep wetted with ... (appropriate material to be specified by the manufacturer)',
        S49: 'S49 - Keep only in the original container',
        S50: 'S50 - Do not mix with ... (to be specified by the manufacturer)',
        S51: 'S51 - Use only in well-ventilated areas',
        S52: 'S52 - Not recommended for interior use on large surface areas',
        S53: 'S53 - Avoid exposure – Obtain special instructions before use',
        S56:
          'S56 - Dispose of this material and its container to hazardous or special waste collection point',
        S57: 'S57 - Use appropriate containment to avoid environmental contamination',
        S59: 'S59 - Refer to manufacturer/supplier for information on recovery/recycling',
        S60: 'S60 - This material and its container must be disposed of as hazardous waste',
        S61:
          'S61 - Avoid release to the environment. Refer to special instructions/safety data sheet',
        S62:
          'S62 - If swallowed, do not induce vomiting: seek medical advice immediately and show this container or label',
        S63:
          'S63 - In case of accident by inhalation: remove casualty to fresh air and keep at rest',
        S64: 'S64 - If swallowed, rinse mouth with water (only if the person is conscious)',
        'S1/2': 'S1/2 - Keep locked up and out of the reach of children.',
        'S3/7': 'S3/7 - Keep container tightly closed in a cool place.',
        'S3/9/14':
          'S3/9/14 - Keep in a cool, well-ventilated place away from … (incompatible materials to be indicated by the manufacturer).',
        'S3/9/49':
          'S3/9/49 -  Keep only in the original container in a cool, well-ventilated place.',
        'S3/9/14/39':
          'S3/9/14/49 - Keep only in the original container in a cool, well-ventilated place away from … (incompatible materials to be indicated by the manufacturer).',
        'S3/14':
          'S3/14 - Keep in a cool place away from … (incompatible materials to be indicated by the manufacturer).',
        'S7/8': 'S7/8 - Keep container tightly closed and dry.',
        'S7/9': 'S7/9 - Keep container tightly closed and in a well-ventilated place.',
        'S7/47':
          'S7/47 - Keep container tightly closed and at a temperature not exceeding … oC (to be specified by the manufacturer).',
        'S20/21': 'S20/21 - When using do not eat, drink or smoke.',
        'S24/25': 'S24/25 - Avoid contact with skin and eyes.',
        'S27/28':
          'S27/28 - After contact with skin, take off immediately all contaminated clothing, and wash immediately with plenty of … (to be specified by the manufacturer).',
        'S29/35':
          'S29/35 - Do not empty into drains; dispose of this material and its container in a safe way.',
        'S29/56':
          'S29/56 - Do not empty into drains, dispose of this material and its container at hazardous or special waste collection point.',
        'S36/37': 'S36/37 - Wear suitable protective clothing and gloves.',
        'S36/39': 'S36/39 - Wear suitable protective clothing and eye/face protection.',
        'S37/39': 'S37/39 - Wear suitable gloves and eye/face protection.',
        'S36/37/39':
          'S36/37/39 - Wear suitable protective clothing, gloves and eye/face protection.',
        'S37/49':
          'S47/49 - Keep only in the original container at a temperature not exceeding … oC (to be specified by the manufacturer).'
      }
    },
    pagination: {
      first: 'First',
      previous: 'Previous',
      previous_arrow: '« Previous',
      next: 'Next',
      next_arrow: 'Next »',
      last: 'Last'
    },
    passwords: {
      reset: 'Your password has been reset!',
      sent: 'We have e-mailed your password reset link!',
      throttled: 'Please wait before retrying.',
      token: 'This password reset token is invalid.',
      user: "We can't find a user with that e-mail address.",
      no_account: 'No account? Sign up!',
      has_account: 'Has account? Sign in!',
      _: 'Password',
      current: 'Current password',
      'no-match': "Current password doesn't match with out records!",
      new: 'New password',
      confirmation: 'Confirm new password',
      change: 'Change current password',
      changed: 'Password has been changed',
      forbidden: 'Forbidden expressions: {expressions} or parts of your name',
      forgot: {
        _: 'Forgotten password?',
        title: 'Reset password',
        send: 'Send password reset request',
        sent: 'Link to restore your password has been sent to the provided email address.'
      }
    },
    permissions: {
      title: 'Permission',
      index: 'Permissions',
      show: 'Permission detail',
      new: 'New permission',
      create: 'Add permission',
      edit: 'Edit permission',
      delete: 'Delete permission',
      roles: 'Assigned roles',
      'roles.none': 'No role has been assigned with this permission.',
      msg: {
        'delete-disabled': 'Permission deletion has been temporarly deactivated.'
      }
    },
    profile: {
      index: 'Profile',
      profile: 'My profile',
      settings: {
        _: 'Settings',
        general: 'General',
        lang: 'Language',
        langs: {
          cs: 'Czech',
          en: 'English'
        },
        listing: 'Number of items per page',
        saved: 'Settings have been updated.'
      },
      socials: {
        _: 'Social networks',
        unlink: 'Unlink account'
      },
      msg: {
        social_unlink: 'Do you really want to unlink social account {name}?',
        social_unlinked: 'Social account {name} has been unlinked.'
      }
    },
    roles: {
      title: 'Role',
      index: 'Roles',
      show: 'Role detail',
      new: 'New role',
      create: 'Add role',
      edit: 'Edit role',
      delete: 'Delete role',
      none: 'No role',
      permissions: {
        none: 'No permission has been assigned to this role',
        assigned: 'Assigned permissions',
        'not-assigned': 'Available permissions for assignment',
        header: 'Save the role header information before permission assignment.'
      },
      users: {
        assigned: 'Users assigned with this role',
        none: 'No user has been assigned with this role'
      },
      msg: {
        'delete-disabled': 'Role deletion has been temporarily deactivated.'
      }
    },
    stores: {
      title: 'Store',
      index: 'Stores',
      all: 'All stores',
      show: 'Store details',
      new: 'New store',
      create: 'Add store',
      edit: 'Edit store',
      delete: 'Delete store',
      select: 'Select a store',
      name: 'Name',
      abbr_name: 'Abbreviation',
      tree_name: 'Full name',
      parent: 'Parent store',
      team: "Store's team",
      children: 'Child stores',
      temp: {
        _: 'Temperature',
        int: 'from {min} to {max} °C',
        min: 'Minimal',
        max: 'Maximal'
      },
      chemicals: 'Stored chemicals',
      msg: {
        has_items: 'Store {name} contains chemicals, firstly move or delete these chemicals.',
        has_children:
          'Store {name} contains children stores, firstly move those to different parent store.',
        name: 'Entered store name already exists within selected sub-store.',
        is_child_or_self: "Store can't be moved into its child store."
      }
    },
    tasks: {
      title: 'Task',
      index: 'Tasks',
      cache: {
        _: 'Temporary files',
        data: {
          _: 'Cached data',
          description: 'Delete temporary application cache data.',
          done: 'Temporary application data has been cleared.'
        },
        sessions: {
          _: 'Cached sessions',
          description: 'Delete session data.',
          done: 'Session files have been cleared.'
        },
        views: {
          _: 'Cached views',
          description: 'Delete cached views.',
          done: 'Cache views have been cleared.'
        }
      }
    },
    teams: {
      title: 'Team',
      index: 'Teams',
      show: 'Team details',
      new: 'New team',
      create: 'Add team',
      edit: 'Edit team',
      delete: 'Delete team',
      name: 'Name',
      'name.internal': 'Internal name',
      stores: {
        _: 'Manageable stores',
        assigned: 'Stores which team can manage',
        none: 'No stores assigned to this team.'
      },
      msg: {
        has_items: 'Team has assigned stores. Firstly, remove assignment and then remove the team.'
      }
    },
    users: {
      title: 'User',
      index: 'Users',
      all: 'All users',
      show: 'User detail',
      new: 'New user',
      create: 'Add user',
      edit: 'Edit user',
      delete: 'Delete user',
      guest: 'Guest',
      details: 'Details',
      name: 'Name',
      email: 'Email',
      phone: 'Phone',
      password: {
        _: 'Password',
        current: 'Current password',
        'no-match': "Current password doesn't match with out records!",
        new: 'New password',
        confirmation: 'Confirm new password',
        forbidden: 'Forbidden expressions: {expressions} or parts of your name',
        forgot: 'Forgotten password?',
        change: 'Change current password',
        changed: 'Password has been changed',
        reset: {
          _: 'Reset password',
          send: 'Send password reset request',
          sent: 'Link to restore your password has been sent to the provided email address.'
        }
      },
      remember: 'Remember me',
      roles: {
        none: 'No role has been assigned with this permission.',
        assigned: 'Currently assigned roles',
        'not-assigned': 'Available roles for assignment',
        header: 'Save the user header information before role assignment.'
      }
    },
    validation: {
      accepted: 'The {attribute} must be accepted.',
      active_url: 'The {attribute} is not a valid URL.',
      after: 'The {attribute} must be a date after {date}.',
      after_or_equal: 'The {attribute} must be a date after or equal to {date}.',
      alpha: 'The {attribute} may only contain letters.',
      alpha_dash: 'The {attribute} may only contain letters, numbers, dashes and underscores.',
      alpha_num: 'The {attribute} may only contain letters and numbers.',
      array: 'The {attribute} must be an array.',
      before: 'The {attribute} must be a date before {date}.',
      before_or_equal: 'The {attribute} must be a date before or equal to {date}.',
      between: {
        numeric: 'The {attribute} must be between {min} and {max}.',
        file: 'The {attribute} must be between {min} and {max} kilobytes.',
        string: 'The {attribute} must be between {min} and {max} characters.',
        array: 'The {attribute} must have between {min} and {max} items.'
      },
      boolean: 'The {attribute} field must be true or false.',
      confirmed: 'The {attribute} confirmation does not match.',
      date: 'The {attribute} is not a valid date.',
      date_equals: 'The {attribute} must be a date equal to {date}.',
      date_format: 'The {attribute} does not match the format {format}.',
      different: 'The {attribute} and {other} must be different.',
      digits: 'The {attribute} must be {digits} digits.',
      digits_between: 'The {attribute} must be between {min} and {max} digits.',
      dimensions: 'The {attribute} has invalid image dimensions.',
      distinct: 'The {attribute} field has a duplicate value.',
      email: 'The {attribute} must be a valid email address.',
      ends_with: 'The {attribute} must end with one of the following: {values}',
      exists: 'The selected {attribute} is invalid.',
      file: 'The {attribute} must be a file.',
      filled: 'The {attribute} field must have a value.',
      gt: {
        numeric: 'The {attribute} must be greater than {value}.',
        file: 'The {attribute} must be greater than {value} kilobytes.',
        string: 'The {attribute} must be greater than {value} characters.',
        array: 'The {attribute} must have more than {value} items.'
      },
      gte: {
        numeric: 'The {attribute} must be greater than or equal {value}.',
        file: 'The {attribute} must be greater than or equal {value} kilobytes.',
        string: 'The {attribute} must be greater than or equal {value} characters.',
        array: 'The {attribute} must have {value} items or more.'
      },
      image: 'The {attribute} must be an image.',
      in: 'The selected {attribute} is invalid.',
      in_array: 'The {attribute} field does not exist in {other}.',
      integer: 'The {attribute} must be an integer.',
      ip: 'The {attribute} must be a valid IP address.',
      ipv4: 'The {attribute} must be a valid IPv4 address.',
      ipv6: 'The {attribute} must be a valid IPv6 address.',
      json: 'The {attribute} must be a valid JSON string.',
      lt: {
        numeric: 'The {attribute} must be less than {value}.',
        file: 'The {attribute} must be less than {value} kilobytes.',
        string: 'The {attribute} must be less than {value} characters.',
        array: 'The {attribute} must have less than {value} items.'
      },
      lte: {
        numeric: 'The {attribute} must be less than or equal {value}.',
        file: 'The {attribute} must be less than or equal {value} kilobytes.',
        string: 'The {attribute} must be less than or equal {value} characters.',
        array: 'The {attribute} must not have more than {value} items.'
      },
      max: {
        numeric: 'The {attribute} may not be greater than {max}.',
        file: 'The {attribute} may not be greater than {max} kilobytes.',
        string: 'The {attribute} may not be greater than {max} characters.',
        array: 'The {attribute} may not have more than {max} items.'
      },
      mimes: 'The {attribute} must be a file of type: {values}.',
      mimetypes: 'The {attribute} must be a file of type: {values}.',
      min: {
        numeric: 'The {attribute} must be at least {min}.',
        file: 'The {attribute} must be at least {min} kilobytes.',
        string: 'The {attribute} must be at least {min} characters.',
        array: 'The {attribute} must have at least {min} items.'
      },
      not_in: 'The selected {attribute} is invalid.',
      not_regex: 'The {attribute} format is invalid.',
      numeric: 'The {attribute} must be a number.',
      password: 'The password is incorrect.',
      phone: 'The {attribute} field contains an invalid number.',
      present: 'The {attribute} field must be present.',
      regex: 'The {attribute} format is invalid.',
      required: 'The {attribute} field is required.',
      required_if: 'The {attribute} field is required when {other} is {value}.',
      required_unless: 'The {attribute} field is required unless {other} is in {values}.',
      required_with: 'The {attribute} field is required when {values} is present.',
      required_with_all: 'The {attribute} field is required when {values} are present.',
      required_without: 'The {attribute} field is required when {values} is not present.',
      required_without_all: 'The {attribute} field is required when none of {values} are present.',
      same: 'The {attribute} and {other} must match.',
      size: {
        numeric: 'The {attribute} must be {size}.',
        file: 'The {attribute} must be {size} kilobytes.',
        string: 'The {attribute} must be {size} characters.',
        array: 'The {attribute} must contain {size} items.'
      },
      starts_with: 'The {attribute} must start with one of the following: {values}',
      string: 'The {attribute} must be a string.',
      timezone: 'The {attribute} must be a valid zone.',
      unique: 'The {attribute} has already been taken.',
      uploaded: 'The {attribute} failed to upload.',
      url: 'The {attribute} format is invalid.',
      uuid: 'The {attribute} must be a valid UUID.',
      custom: {
        recaptcha: {
          required: "ReCaptcha hasn't been filled properly."
        },
        password: {
          allowed: 'Password contains not allowed strings: {attribute}.'
        }
      },
      attributes: []
    }
  }
};
