import java.sql.Date;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.sql.Date;

public class DataGenerator {
    public static void main(String args[]) {

        RandomHelper rdm = new RandomHelper();
        DatabaseHelper dbHelper = new DatabaseHelper();

        int count_costumer = 0;
        int count_locations = 0;
        int count_car = 0;
        int count_billing = 0;
        int count_insurance = 0;
        int count_reservation = 0;
        int count_rent = 0;
        int count_friendship = 0;

        while (count_costumer < 400) {
            String email = rdm.getRandomEmail();
            int phone = rdm.getRandomInteger(100000000, 999999999);
            String firstName = rdm.getRandomFirstName();
            String lastName = rdm.getRandomLastName();
            int locId = rdm.getRandomInteger(0, 100);

            if (dbHelper.insertIntoCostumer(email, phone, firstName, lastName, locId)) {
                count_costumer++;
            }
        }

       ArrayList<String> email = dbHelper.selectCostumerEmail();
       System.out.println("There are " + email.size() + " costumers in our database!");
        
        while(count_locations < 100) {
            int locId = count_locations+1;
            int postcode = rdm.getRandomPostcode();
            String street = rdm.getRandomString(5, 15);
            String city = "Vienna";
            if(dbHelper.insertIntoLocation(locId, postcode, street, city)){
                count_locations++;
            }
        }
        
        ArrayList<Integer> locId = dbHelper.selectLocationId();
        System.out.println("There are " + locId.size() + " locations in our database!");
 
     
        ArrayList<Integer> registrationNumber = dbHelper.selectRegistrationNumber();
        System.out.println("There are " + registrationNumber.size() + " cars in our database!");

        while (count_car < 200) {
            int regnr = count_car+1;
            String cmodel= rdm.getRandomString(4, 14);
            int year = rdm.getRandomInteger(2000, 2020);
            int price = rdm.getRandomInteger(30, 100);

            if(dbHelper.insertIntoCar(regnr, cmodel, year, price)){
                count_car++;
            }
        }

        while (count_billing<100) {
            int nr = count_billing+1;
            int total = rdm.getRandomInteger(0, 1000);

            long millis=System.currentTimeMillis();
            java.sql.Date date=new java.sql.Date(millis);
            String c_mail = rdm.getRandomEmail();

            if(dbHelper.insertIntoBilling(nr, total, date.toString(), c_mail)){
                count_billing++;
            }
        }
        
        int countBilling = dbHelper.selectCountAllFromBilling();
        System.out.println("There are " + countBilling + " entities in the table 'Billing' in our database!");

      
        while (count_reservation<100) {
            int nr = count_reservation+1;
            java.sql.Date date_from = new  java.sql.Date(System.currentTimeMillis());
            java.sql.Date date_return = new  java.sql.Date(System.currentTimeMillis());

            int amount = rdm.getRandomInteger(50, 1000);
            int billnr = rdm.getRandomInteger(0, 100);

            if(dbHelper.insertIntoReservation(nr, date_from.toString(), date_return.toString(), amount, billnr)){
                count_reservation++;
            }
        }
          
        while (count_insurance<100) {
            int nr = count_insurance+1;
            String name = rdm.getRandomFirstName() + " insurance";
            if (dbHelper.insertIntoInsurance(nr, name)){
                count_insurance++;
            }
        }

        while (count_friendship < 200){
            String c_email_1 = rdm.getRandomEmail();
            String c_email_2 = rdm.getRandomEmail();
            if(!(c_email_1.equals(c_email_2))){
                if(dbHelper.insertIntoAreFriends(c_email_1, c_email_2)){
                    count_friendship++;
                }
            }
        }

        while (count_rent < registrationNumber.size()) {
            int regnr = registrationNumber.get(count_rent);
            String rent_email = rdm.getRandomEmail();
            int rent_reservation = count_rent+1;
            if(dbHelper.insertIntoRent(rent_email, regnr, rent_reservation)){
                count_rent++;
            }
        }

        ArrayList<String> rent = dbHelper.selectRENTSize();
        System.out.println("There are " + rent.size() + " car rented!");

        dbHelper.close();
    }
}
