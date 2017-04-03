DROP TABLE patients, medications, patientData, marketingStatus, marketingStatusLookup, products;
DROP TABLE products;


CREATE TABLE patients (ID INT, FNAME VARCHAR(100), LNAME VARCHAR(100));
CREATE TABLE medications (medID INT, CLINNAME VARCHAR (100), NAMEBRAND VARCHAR (100));
CREATE TABLE patientData(ID INT PRIMARY KEY, medID INT);
CREATE TABLE marketingStatus(applNo INT, productNo INT, marketingStatusID INT);
CREATE TABLE marketingStatusLookup(marketingStatusID INT, description VARCHAR (100));
CREATE TABLE products(applNo INT, productNo INT, form VARCHAR(100), strength VARCHAR(300), drugName VARCHAR (200), activeIngredient VARCHAR (300));

SELECT 
    *
FROM
    products
        LEFT JOIN
    marketingStatus ON products.applNo = marketingStatus.applNo
        && products.productNo = marketingStatus.productNo
WHERE
    products.form = 'TABLET;ORAL';
 
 SELECT COUNT(*) FROM products WHERE products.form = 'TABLET;ORAL';