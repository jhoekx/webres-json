insert into ResultNames (NamePK, FirstLastName) values (1, 'Jeroen Hoekx'), (2, 'Wim Hoekx'), (3, 'Desmond Franssen');
insert into ResultNames (NamePK, FirstLastName) values (4, 'Tést');
insert into ResultClubs (ClubPK, ClubName) values (1, "hamok"), (2, "trol");
insert into ResultHeader (CompetitionPK, CompDate, EventDescription) values (1, NOW(), "Test");
insert into ResultCategories (CatPK, ResFK, CategoryName) values (1, 1, "HE"), (2, 1, "H55");
insert into ResultData (ResFK, CatFK, ClubFK, NameFK, Position, CourseTime, StatusFK) values (1, 1, 2, 3, 1, "1:23:45", 0);
insert into ResultData (ResFK, CatFK, ClubFK, NameFK, Position, CourseTime, StatusFK) values (1, 1, 1, 1, 2, "1:23:46", 0);
insert into ResultData (ResFK, CatFK, ClubFK, NameFK, Position, CourseTime, StatusFK) values (1, 2, 1, 2, 1, "1:23:45", 0);
insert into ResultData (ResFK, CatFK, ClubFK, NameFK, Position, CourseTime, StatusFK) values (1, 2, 1, 4, 2, "1:23:46", 0);