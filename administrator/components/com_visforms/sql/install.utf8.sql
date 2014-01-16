create table #__visforms
(
   id                           int(11) not null AUTO_INCREMENT,
   asset_id INTEGER UNSIGNED NOT NULL DEFAULT 0,
   name                         text,
   title                        text,
   checked_out tinyint(1) NOT NULL default '0',
   checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
   description                  longtext,
   emailfrom                    text,
   emailto                      text,
   emailcc                      text,
   emailbcc                     text,
   subject						text,	
   created                      datetime,
   created_by                   int(11),
   hits                         int(11),
   published                    tinyint,
   saveresult                   tinyint,
   emailresult                  tinyint,
   textresult                   longtext,
   redirecturl					text,
   spambotcheck                 tinyint(1) NOT NULL default '0',
   captcha                    	tinyint,
   captchacustominfo		    text,
   captchacustomerror		    text,	
   uploadpath					text,
   maxfilesize					int,
   allowedextensions			text,
   poweredby                   	tinyint,
   emailreceipt                 tinyint,
   emailreceipttext             longtext,
   emailreceiptsubject			text,
   emailreceiptincfield         tinyint,
   emailreceiptincfile          tinyint,
   emailresultincfile           tinyint,
   formCSSclass					text,
   displayip		            tinyint,
   displaydetail		        tinyint,
   fronttitle                   text,
   frontdescription             longtext,
   autopublish					tinyint, 
   language char(7) NOT NULL,   
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


create table #__visfields
(
   id                           int(11) not null AUTO_INCREMENT,
   fid                          int(11),
   name                         text,
   label                  	    text,
   checked_out tinyint(1) NOT NULL default '0',
   checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
   typefield                    text,
   defaultvalue					text,
   mandatory                    tinyint,
   published                    tinyint,
   ordering                     int(11) not null DEFAULT 0, 
   custominfo					text,
   customerror					text,
   customvalidation				text,
   readonly                		tinyint,
   labelCSSclass				text,
   fieldCSSclass				text,
   customtext					text,
   frontdisplay					tinyint,
   fillwith						text,
   primary key (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;