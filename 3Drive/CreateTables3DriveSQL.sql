CREATE TABLE USERS
	(Username VARCHAR(20),
     Password VARCHAR(20),
     	CONSTRAINT USER_Username_pk PRIMARY KEY (Username));
       
CREATE TABLE FILES
	(Username VARCHAR(20),
     Filename VARCHAR(20),
	 FileID INT(6),
     Manifold CHAR(1),
     DateAdded DATE,
     CONSTRAINT FILES_FileID_pk PRIMARY KEY (FileID),
     CONSTRAINT FILES_Username_fk FOREIGN KEY (Username)
     	REFERENCES USERS (Username));
		
CREATE TABLE FOLDERS
	(FolderID INT(6),
	FileID INT(6),
	Username VARCHAR(20),
	CONSTRAINT FOLDERS_FolderID_pk PRIMARY KEY (FolderID),
    CONSTRAINT FOLDERS_FileID_fk FOREIGN KEY (FileID)
    	REFERENCES FILES (FileID),
	CONSTRAINT FOLDERS_Username_fk FOREIGN KEY (Username)
     	REFERENCES USERS (Username));