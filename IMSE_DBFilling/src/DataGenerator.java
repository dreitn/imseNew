import java.sql.Date;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.sql.Date;

public class DataGenerator {
    public static void main(String args[]) {

        RandomHelper rdm = new RandomHelper();
        DatabaseHelper dbHelper = new DatabaseHelper();

        int costumer = 0;
       while (costumer < 200) {
        	String email = rdm.getRandomEmail();
            int phone = rdm.getRandomInteger(100000000, 999999999);
            String firstName = rdm.getRandomFirstName();
            String lastName = rdm.getRandomLastName();
            int locId = rdm.getRandomInteger(0, 100);

            if (dbHelper.insertIntoCostumer(email, phone, firstName, lastName, locId)) {
                costumer++;
            }
        }

       ArrayList<String> email = dbHelper.selectCostumerEmail();
       System.out.println("There are " + email.size() + " costumers in our database!");
        
        for (int i = 0; i < 100; i++) {
        	int locId = i+1;
        	int postcode = rdm.getRandomPostcode();
        	String street = rdm.getRandomString(5, 15);
        	String city = "Vienna";
            dbHelper.insertIntoLocation(locId, postcode, street, city);
        }
        
        ArrayList<Integer> locId = dbHelper.selectLocationId();
        System.out.println("There are " + locId.size() + " locations in our database!");
 
     
        ArrayList<Integer> registrationNumber = dbHelper.selectRegistrationNumber();
        System.out.println("There are " + registrationNumber.size() + " cars in our database!");
        

        for (int i = 1; i < 2000; i++) {
            int regnr = i;
            String cmodel= rdm.getRandomString(4, 14);
            int year = rdm.getRandomInteger(2000, 2019);
            int price = rdm.getRandomInteger(30, 100);

           dbHelper.insertIntoCar(regnr, cmodel, year, price);
        }

        for (int i = 0; i < 100; i++) { 
            int nr = i;
            int total = rdm.getRandomInteger(0, 1000);

            long millis=System.currentTimeMillis();
            java.sql.Date date=new java.sql.Date(millis);
            String c_mail = rdm.getRandomEmail();

            dbHelper.insertIntoBilling(nr, total, date.toString(), c_mail);
        }
        
        int countBilling = dbHelper.selectCountAllFromBilling();
        System.out.println("There are " + countBilling + " entities in the table 'Billing' in our database!");

      
        for (int i = 0; i <100; i++) { 
            int nr = i+1;
            java.sql.Date date_from = new  java.sql.Date(System.currentTimeMillis());
            java.sql.Date date_return = new  java.sql.Date(System.currentTimeMillis());

            int amount = rdm.getRandomInteger(50, 1000);
            int billnr = rdm.getRandomInteger(0, 100);

            dbHelper.insertIntoReservation(nr, date_from.toString(), date_return.toString(), amount, billnr);
        }
          
        for (int i = 0 ; i < 600; i++) {
            int nr = i;
            String name = rdm.getRandomFirstName() + " insurance";
            dbHelper.insertIntoInsurance(nr, name);
        }

        for(int i = 0; i<300; i++){
            String c_email_1 = rdm.getRandomEmail();
            String c_email_2 = rdm.getRandomEmail();
            if(!(c_email_1.equals(c_email_2))){
            dbHelper.insertIntoAreFriends(c_email_1, c_email_2);
            }
        }

        for (int i = 0; i < registrationNumber.size(); i++) {
            int regnr = registrationNumber.get(i);
            String rent_email = rdm.getRandomEmail();
            int rent_reservation = i;
            dbHelper.insertIntoRent(rent_email, regnr, rent_reservation);
        }

        ArrayList<String> rent = dbHelper.selectRENTSize();
        System.out.println("There are " + rent.size() + " car rented!");

        dbHelper.close();
    }
}
