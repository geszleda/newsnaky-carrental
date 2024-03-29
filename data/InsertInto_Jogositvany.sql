INSERT INTO jogositvany (id, ugyfel_id, kategoria, azonositoszam, automatavaltos_e, kiallitas_idopontja)
VALUES (1, 1, 'B', 'DEK12345', 'false', DATE '1994-03-22'),
       (2, 2, 'B', 'DEK12346', 'false', DATE '2000-08-12'),
       (3, 3, 'B', 'DEK12347', 'false', DATE '2015-02-14'),
       (4, 4, 'B', 'DEK12348', 'true', DATE '1999-04-11'),
       (5, 5, 'B', 'DEK12349', 'false', DATE '2005-07-22'),
       (6, 6, 'C', 'DEK12350', 'false', DATE '2010-11-05'),
       (7, 7, 'A', 'DEK12351', 'false', DATE '1995-01-13'),
       (8, 8, 'B', 'DEK12352', 'false', DATE '2008-09-21'),
       (9, 9, 'B', 'DEK12353', 'false', DATE '1995-07-15'),
       (10, 10, 'C', 'DEK12354', 'false', DATE '2002-03-03'),
       (11, 11, 'A', 'DEK12355', 'true', DATE '2012-08-01'),
       (12, 12, 'B', 'DEK12356', 'false', DATE '2005-05-22'),
       (13, 13, 'B', 'DEK12357', 'false', DATE '1999-11-30'),
       (14, 14, 'B', 'DEK12358', 'false', DATE '2008-05-13'),
       (15, 15, 'B', 'DEK12359', 'false', DATE '2010-06-23'),
       (16, 16, 'C', 'DEK12360', 'false', DATE '2007-01-15'),
       (17, 17, 'B', 'DEK12361', 'false', DATE '2001-02-25'),
       (18, 18, 'B', 'DEK12362', 'false', DATE '2008-09-10'),
       (19, 19, 'B', 'DEK12363', 'false', DATE '2003-04-15'),
       (20, 20, 'B', 'DEK12364', 'false', DATE '2010-07-20');

CREATE SEQUENCE jogositvany_sequence
  start 21
  increment 1;