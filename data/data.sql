/*==============================================================*/
/* Nom de SGBD :  PostgreSQL 8                                  */
/* Date de cr�ation :  19/10/2020 09:34:37                      */
/*==============================================================*/
CREATE DATABASE evaluation WITH OWNER toky;
GRANT ALL PRIVILEGES ON DATABASE evaluation TO toky;

drop table ADMIN;

drop table UTILISATEUR;

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