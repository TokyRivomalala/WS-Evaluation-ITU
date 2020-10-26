/*==============================================================*/
/* Nom de SGBD :  PostgreSQL 8                                  */
/* Date de cr�ation :  19/10/2020 09:34:37                      */
/*==============================================================*/
-- CREATE DATABASE evaluation WITH OWNER toky;
-- GRANT ALL PRIVILEGES ON DATABASE evaluation TO toky;

-- drop table ADMIN;

-- drop table UTILISATEUR;

/*==============================================================*/
/* Table : ADMIN                                                */
/*==============================================================*/
create table ADMIN (
   IDADMIN              VARCHAR(30)          not null,
   EMAIL                VARCHAR(40)          not null,
   MDP                  VARCHAR(20)          not null,
   TOKEN                VARCHAR(100)          null,
   TOKENEXPIRATION      TIMESTAMP            null,
   constraint PK_ADMIN primary key (IDADMIN)
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
   TOKEN                VARCHAR(100)          null,
   TOKENEXPIRATION      TIMESTAMP            null,
   constraint PK_UTILISATEUR primary key (IDUTIL)
);


CREATE SEQUENCE admin_seq;
CREATE SEQUENCE utilisateur_seq;

INSERT INTO ADMIN (IDADMIN,EMAIL,MDP) VALUES (CONCAT('AD',lpad(nextval('admin_seq')::text,2,'0')),'toky@gmail.com','toky');

INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rakoto','Njiva','01-01-1999','njiva@yahoo.com','Homme','njiva');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rabe','Soa','01-09-1998','soa@yahoo.com','Femme','soa');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Randria','Hasina','01-12-1997','hasina@yahoo.com','Femme','hasina');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rasolo','Fetra','01-10-1996','fetra@yahoo.com','Homme','fetra');
INSERT INTO UTILISATEUR (IDUTIL,NOM,PRENOM,DATENAISS,EMAIL,SEXE,MDP) VALUES (CONCAT('UT',lpad(nextval('utilisateur_seq')::text,2,'0')),'Rafidy','Solo','01-04-1995','solo@yahoo.com','Homme','solo');

create table testDate(
   date TIMESTAMP
);

insert into testDate (date) values ('01-01-2000');


DROP SEQUENCE admin_seq;
DROP SEQUENCE utilisateur_seq;
DROP SEQUENCE article_seq;
DROP SEQUENCE stockarticle_seq;
DROP SEQUENCE pourcentage_seq;
DROP SEQUENCE gratuit_seq;
DROP SEQUENCE remise_seq;
DROP SEQUENCE achat_seq;
DROP SEQUENCE ticket_seq;

CREATE SEQUENCE admin_seq;
CREATE SEQUENCE utilisateur_seq;
CREATE SEQUENCE article_seq;
CREATE SEQUENCE stockarticle_seq;
CREATE SEQUENCE pourcentage_seq;
CREATE SEQUENCE gratuit_seq;
CREATE SEQUENCE remise_seq;
CREATE SEQUENCE achat_seq;
CREATE SEQUENCE ticket_seq;

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

