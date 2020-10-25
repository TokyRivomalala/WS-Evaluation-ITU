/*==============================================================*/
/* Nom de SGBD :  PostgreSQL 8                                  */
/* Date de cr�ation :  25/10/2020 23:20:10                      */
/*==============================================================*/


drop view ACHATCOMPLET CASCADE;

drop view ARTICLECOMPLET CASCADE;

drop view ARTICLEETSTOCK CASCADE;

drop view REMISECOMPLET CASCADE;

drop view REMISEPOURCENTAGE CASCADE;

drop view TICKETCOMPLET CASCADE;

drop table ACHAT CASCADE;

drop table ADMIN CASCADE;

drop table ARTICLE CASCADE;

drop table GRATUIT CASCADE;

drop table POURCENTAGE CASCADE;

drop table REMISE CASCADE;

drop table STOCKARTICLE CASCADE;

drop table TICKET CASCADE;

drop table UTILISATEUR CASCADE;

/*==============================================================*/
/* Table : ADMIN                                                */
/*==============================================================*/
create table ADMIN (
   IDADMIN              VARCHAR(30)          not null,
   EMAIL                VARCHAR(40)          not null,
   MDP                  VARCHAR(20)          not null,
   TOKEN                VARCHAR(100)         null,
   TOKENEXPIRATION      TIMESTAMP            null,
   constraint PK_ADMIN primary key (IDADMIN)
);

/*==============================================================*/
/* Table : ARTICLE                                              */
/*==============================================================*/
create table ARTICLE (
   IDARTICLE            VARCHAR(30)          not null,
   DESIGNATION          VARCHAR(50)          not null,
   CODE                 VARCHAR(3)           not null,
   constraint PK_ARTICLE primary key (IDARTICLE)
);

/*==============================================================*/
/* Table : GRATUIT                                              */
/*==============================================================*/
create table GRATUIT (
   IDGRATUIT            VARCHAR(30)          not null,
   NBMIN                FLOAT                not null,
   NBGRATUIT            FLOAT                not null,
   constraint PK_GRATUIT primary key (IDGRATUIT)
);

/*==============================================================*/
/* Table : POURCENTAGE                                          */
/*==============================================================*/
create table POURCENTAGE (
   IDPOURCENTAGE        VARCHAR(50)          not null,
   POURCENTAGE          FLOAT                not null,
   constraint PK_POURCENTAGE primary key (IDPOURCENTAGE)
);

/*==============================================================*/
/* Table : REMISE                                               */
/*==============================================================*/
create table REMISE (
   IDARTICLE            VARCHAR(30)          null,
   IDGRATUIT            VARCHAR(30)          null,
   IDPOURCENTAGE        VARCHAR(50)          null
);

/*==============================================================*/
/* Table : STOCKARTICLE                                         */
/*==============================================================*/
create table STOCKARTICLE (
   IDARTICLE            VARCHAR(30)          null,
   QUANTITESTOCK        FLOAT                not null,
   PRIXUNITAIRE         FLOAT                not null
);

/*==============================================================*/
/* Table : ACHAT                                                */
/*==============================================================*/
create table ACHAT (
   IDACHAT              VARCHAR(30)          not null,
   IDARTICLE            VARCHAR(30)          null,
   DATEACHAT            TIMESTAMP            null,
   QUANTITEPROD         FLOAT                not null,
   PRIXTOTAL            FLOAT                not null,
   ETAT                 INT                  not null,
   constraint PK_ACHAT primary key (IDACHAT)
);


/*==============================================================*/
/* Table : TICKET                                               */
/*==============================================================*/
create table TICKET (
   IDTICKET             VARCHAR(30)          not null,
   IDACHAT              VARCHAR(30)          null,
   DATETICKET           TIMESTAMP            not null,
   PRIXTOTAL            FLOAT                not null,
   constraint PK_TICKET primary key (IDTICKET)
);

/*==============================================================*/
/* Table : UTILISATEUR                                          */
/*==============================================================*/
create table UTILISATEUR (
   IDUTIL               VARCHAR(30)          not null,
   NOM                  VARCHAR(30)          not null,
   PRENOM               VARCHAR(30)          not null,
   DATENAISS            DATE                 not null,
   EMAIL                VARCHAR(40)          not null,
   SEXE                 VARCHAR(10)          not null,
   MDP                  VARCHAR(20)          not null,
   TOKEN                VARCHAR(100)         null,
   TOKENEXPIRATION      TIMESTAMP            null,
   constraint PK_UTILISATEUR primary key (IDUTIL)
);

/*==============================================================*/
/* Vue : ARTICLEETSTOCK                                         */
/*==============================================================*/
create or replace view ARTICLEETSTOCK as
select
Article.idArticle,
Article.designation,
Article.code,
StockArticle.quantiteStock,
StockArticle.prixUnitaire
FROM StockArticle JOIN Article ON Article.idArticle = StockArticle.idArticle;

/*==============================================================*/
/* Vue : REMISEPOURCENTAGE                                      */
/*==============================================================*/
create or replace view REMISEPOURCENTAGE as
select
Pourcentage.idPourcentage,
Pourcentage.pourcentage,
Remise.idArticle,
Remise.idGratuit
FROM Pourcentage JOIN Remise ON Pourcentage.idPourcentage = Remise.idPourcentage;

/*==============================================================*/
/* Vue : REMISECOMPLET                                          */
/*==============================================================*/
create or replace view REMISECOMPLET as
select
RemisePourcentage.idPourcentage,
RemisePourcentage.pourcentage,
RemisePourcentage.idArticle,
RemisePourcentage.idGratuit,
Gratuit.nbMin,
Gratuit.nbGratuit
FROM Gratuit JOIN RemisePourcentage ON Gratuit.idGratuit = RemisePourcentage.idGratuit;


/*==============================================================*/
/* Vue : ARTICLECOMPLET                                         */
/*==============================================================*/
create or replace view ARTICLECOMPLET as
select
RemiseComplet.idPourcentage,
RemiseComplet.pourcentage,
RemiseComplet.idArticle,
RemiseComplet.idGratuit,
RemiseComplet.nbMin,
RemiseComplet.nbGratuit,
ArticleEtStock.designation,
ArticleEtStock.code,
ArticleEtStock.quantiteStock,
ArticleEtStock.prixUnitaire
FROM RemiseComplet JOIN ArticleEtStock ON RemiseComplet.idArticle = ArticleEtStock.idArticle;


/*==============================================================*/
/* Vue : ACHATCOMPLET                                           */
/*==============================================================*/
create or replace view ACHATCOMPLET as
select
ArticleComplet.idArticle,
ArticleComplet.designation,
ArticleComplet.code,
ArticleComplet.quantiteStock,
ArticleComplet.prixUnitaire,
ArticleComplet.pourcentage,
ArticleComplet.idPourcentage,
ArticleComplet.idGratuit,
ArticleComplet.nbMin,
ArticleComplet.nbGratuit,
Achat.idAchat,
Achat.dateAchat,
Achat.quantiteProd,
Achat.prixTotal,
Achat.etat
FROM ArticleComplet JOIN Achat ON Achat.idArticle = ArticleComplet.idArticle;

/*==============================================================*/
/* Vue : TICKETCOMPLET                                          */
/*==============================================================*/
create or replace view TICKETCOMPLET as
select
AchatComplet.idArticle,
AchatComplet.designation,
AchatComplet.code,
AchatComplet.quantiteStock,
AchatComplet.prixUnitaire,
AchatComplet.pourcentage,
AchatComplet.idPourcentage,
AchatComplet.idGratuit,
AchatComplet.nbMin,
AchatComplet.nbGratuit,
AchatComplet.idAchat,
AchatComplet.dateAchat,
AchatComplet.quantiteProd,
AchatComplet.prixTotal,
AchatComplet.etat,
Ticket.idTicket,
Ticket.dateTicket
FROM AchatComplet JOIN Ticket ON AchatComplet.idAchat = Ticket.idAchat;

alter table ACHAT
   add constraint FK_ACHAT_REFERENCE_ARTICLE foreign key (IDARTICLE)
      references ARTICLE (IDARTICLE)
      on delete restrict on update restrict;

alter table REMISE
   add constraint FK_REMISE_REFERENCE_ARTICLE foreign key (IDARTICLE)
      references ARTICLE (IDARTICLE)
      on delete restrict on update restrict;

alter table REMISE
   add constraint FK_REMISE_REFERENCE_GRATUIT foreign key (IDGRATUIT)
      references GRATUIT (IDGRATUIT)
      on delete restrict on update restrict;

alter table REMISE
   add constraint FK_REMISE_REFERENCE_POURCENT foreign key (IDPOURCENTAGE)
      references POURCENTAGE (IDPOURCENTAGE)
      on delete restrict on update restrict;

alter table STOCKARTICLE
   add constraint FK_STOCKART_REFERENCE_ARTICLE foreign key (IDARTICLE)
      references ARTICLE (IDARTICLE)
      on delete restrict on update restrict;

alter table TICKET
   add constraint FK_TICKET_REFERENCE_ACHAT foreign key (IDACHAT)
      references ACHAT (IDACHAT)
      on delete restrict on update restrict;


CREATE SEQUENCE admin_seq;
CREATE SEQUENCE utilisateur_seq;
CREATE SEQUENCE article_seq;
CREATE SEQUENCE stockarticle_seq;
CREATE SEQUENCE pourcentage_seq;
CREATE SEQUENCE gratuit_seq;
CREATE SEQUENCE remise_seq;
CREATE SEQUENCE achat_seq;

INSERT INTO ADMIN (IDADMIN,EMAIL,MDP) VALUES (CONCAT('AD',lpad(nextval('admin_seq')::text,2,'0')),'toky@gmail.com','toky');

INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rakoto','Njiva','01-01-1999','njiva@yahoo.com','Homme','njiva');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rabe','Soa','01-09-1998','soa@yahoo.com','Femme','soa');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Randria','Hasina','01-12-1997','hasina@yahoo.com','Femme','hasina');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rasolo','Fetra','01-10-1996','fetra@yahoo.com','Homme','fetra');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rafidy','Solo','01-04-1995','solo@yahoo.com','Homme','solo');


INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Petit Sablé Citron Gouty','PSG');
INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Biscuit Gouty Beurre','BGB');
INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Biscuit Tuc','TUC');
INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Croquette poulet KIPKOP','CPK');
INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Mini madeleine au Beurre Gouty','MMG');
INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Bolo Duo Choco','BDC');
INSERT INTO ARTICLE (IDARTICLE,DESIGNATION,CODE) VALUES (CONCAT('ART',lpad(nextval('article_seq')::text,2,'0')),'Bolo Duo Vanille','BDV');

INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART01',20,1100);
INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART02',08,1000);
INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART03',14,2300);
INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART04',22,600);
INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART05',25,1600);
INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART06',13,300);
INSERT INTO STOCKARTICLE (IDARTICLE,QUANTITESTOCK,PRIXUNITAIRE) VALUES ('ART07',11,300);

INSERT INTO POURCENTAGE (IDPOURCENTAGE,POURCENTAGE) VALUES (CONCAT('PRC',lpad(nextval('pourcentage_seq')::text,2,'0')),0);
INSERT INTO POURCENTAGE (IDPOURCENTAGE,POURCENTAGE) VALUES (CONCAT('PRC',lpad(nextval('pourcentage_seq')::text,2,'0')),21.27);
INSERT INTO POURCENTAGE (IDPOURCENTAGE,POURCENTAGE) VALUES (CONCAT('PRC',lpad(nextval('pourcentage_seq')::text,2,'0')),15);
INSERT INTO POURCENTAGE (IDPOURCENTAGE,POURCENTAGE) VALUES (CONCAT('PRC',lpad(nextval('pourcentage_seq')::text,2,'0')),0.02);

INSERT INTO GRATUIT (IDGRATUIT,NBMIN,NBGRATUIT) VALUES (CONCAT('GRT',lpad(nextval('gratuit_seq')::text,2,'0')),1,0);
INSERT INTO GRATUIT (IDGRATUIT,NBMIN,NBGRATUIT) VALUES (CONCAT('GRT',lpad(nextval('gratuit_seq')::text,2,'0')),3,1);
INSERT INTO GRATUIT (IDGRATUIT,NBMIN,NBGRATUIT) VALUES (CONCAT('GRT',lpad(nextval('gratuit_seq')::text,2,'0')),1,2);
INSERT INTO GRATUIT (IDGRATUIT,NBMIN,NBGRATUIT) VALUES (CONCAT('GRT',lpad(nextval('gratuit_seq')::text,2,'0')),2,2);

INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART01','GRT01','PRC01');
INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART02','GRT02','PRC04');
INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART03','GRT03','PRC02');
INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART04','GRT04','PRC03');
INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART05','GRT03','PRC03');
INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART06','GRT02','PRC02');
INSERT INTO REMISE (IDARTICLE,IDGRATUIT,IDPOURCENTAGE) VALUES ('ART07','GRT01','PRC01');

INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART01','22-10-2020',3,2200,1);
INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART02','22-10-2020',4,4000,1);
INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART03','22-10-2020',5,11500,1);
INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART04','22-10-2020',6,3600,1);
INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART05','22-10-2020',7,11200,1);
INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART06','22-10-2020',8,2400,1);
INSERT INTO ACHAT (IDACHAT,IDARTICLE,DATEACHAT,QUANTITEPROD,PRIXTOTAL,ETAT) VALUES (CONCAT('ACH',lpad(nextval('achat_seq')::text,2,'0')),'ART07','22-10-2020',9,2700,1);




