CREATE TABLE User (
    UserId INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Bio TEXT DEFAULT NULL,
    DOB DATE NOT NULL,
    ImageId INT,
    FOREIGN KEY (ImageId) REFERENCES Images(ImageId)
);

CREATE TABLE Admin (
    AdminId INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    UniqueId VARCHAR(50) NOT NULL,
    Permissions VARCHAR(255),
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE Threads (
    ThreadId INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Tags VARCHAR(255),
    Content TEXT NOT NULL,
    UserId INT NOT NULL,
    Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ImageId INT,
    FOREIGN KEY (UserId) REFERENCES User(UserId),
    FOREIGN KEY (ImageId) REFERENCES Images(ImageId)
);

CREATE TABLE Comments (
    CommentId INT PRIMARY KEY AUTO_INCREMENT,
    ThreadId INT,
    Username VARCHAR(50) NOT NULL,
    Content TEXT NOT NULL,
    Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ThreadId) REFERENCES Threads(ThreadId)
);

CREATE TABLE Images (
    ImageId INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    ImgFile BLOB NOT NULL
);
