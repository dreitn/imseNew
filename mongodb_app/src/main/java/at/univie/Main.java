package at.univie;

import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import org.bson.Document;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Logger;

public class Main {

    public static void main(String[] args) {

        Logger LOG = Logger.getLogger(Main.class.getName());
//Connect MongoDB
        MongoClient mongoClient = MongoClients.create("mongodb://root:example@localhost/");
        MongoDatabase database = mongoClient.getDatabase("admin");
//Connect MariaDB
        MariaDBConnection maria = new MariaDBConnection();
        Statement stmt = maria.getStmt();
        Connection con = maria.getCon();
//Create Collections first
        MongoCollection<Document> collectionCostumer = database.getCollection("Costumer");
        MongoCollection<Document> collectionReservation = database.getCollection("Booking");
        MongoCollection<Document> collectionTest = database.getCollection("test");

        LOG.info("Collections are set and we can start to migrate!!!");


        String costumerQuery = "SELECT * FROM COSTUMER";
        String reservationQuery = "SELECT * FROM RESERVATION";
        try {
            Statement st = con.createStatement();
            ResultSet rs = st.executeQuery(costumerQuery);
            ResultSet resQuery = st.executeQuery(reservationQuery);
            MariaDBQueries mariaDBQueries = new MariaDBQueries(st, con);

//creating the Costumer collection which includes costumer, bills, locations, friends
            while (rs.next()) {
                String email = rs.getString("EMAIL");
                String locationId = rs.getString("LOCATIONID");

                Document costumerDoc = new Document("EMAIL", rs.getString("EMAIL"))
                        .append("FIRSTNAME", rs.getString("FIRSTNAME"))
                        .append("SURNAME", rs.getString("SURNAME"))
                        .append("PHONE_NUMBER", rs.getString("PHONE_NUMBER"))
                        .append("LOCATIONID", rs.getString("LOCATIONID"));

                List<Document> listofbills = new ArrayList<>();
                ResultSet bs = mariaDBQueries.getEmailByCostumerEmail(email);
                while (bs.next()) {
                    Document billingDoc = new Document("BILLING_NUMBER", bs.getString("BILL_NUMBER"))
                            .append("TOTAL_PRICE", bs.getString("TOTAL_PRICE"))
                            .append("BILLDATE", bs.getString("BILLDATE"))
                            .append("C_EMAIL", bs.getString("C_EMAIL"));
                    listofbills.add(billingDoc);

                }
                costumerDoc.append("BILLING", listofbills);
                bs.close();

                ResultSet ls = mariaDBQueries.getLocationByLocationID(locationId);
                List<Document> listofloc = new ArrayList<>();
                while (ls.next()) {
                    Document locationDoc = new Document("LOCATION_ID", ls.getString("LOCATION_ID"))
                            .append("ZIP_CODE", ls.getString("ZIP_CODE"))
                            .append("STREET", ls.getString("STREET"))
                            .append("CITY", ls.getString("CITY"));
                    listofloc.add(locationDoc);
                }
                costumerDoc.append("LOCATIONS", listofloc);
                ls.close();

                ResultSet fs = mariaDBQueries.getAreFriendsByCostumerEmail(email);
                List<Document> listoffriends = new ArrayList<>();
                while (fs.next()) {
                    Document friendsDoc = new Document("FRIENDS", fs.getString("friend_costumer_email_2"));
                    listoffriends.add(friendsDoc);
                }
                costumerDoc.append("FRIENDS", listoffriends);
                fs.close();

                System.out.println(costumerDoc.toJson());
            }
            LOG.info("Costumer collection has created!");
//creating Reservation collection which includes insurance, car, bill
            while(resQuery.next()){

                String resevationbillnumber = resQuery.getString("RESERVATION_BILL_NUMBER");
                String resevationnumber = resQuery.getString("RESERVATION_NUMBER");

                Document reservationDoc = new Document("RESERVATION_NUMBER", resQuery.getString("RESERVATION_NUMBER"))
                        .append("FROM_DATE", resQuery.getString("FROM_DATE"))
                        .append("RETURN_DATE", resQuery.getString("RETURN_DATE"))
                        .append("AMOUNT", resQuery.getString("AMOUNT"));

                ResultSet rb = mariaDBQueries.getReservationBill(resevationbillnumber);
                List<Document> reslistofbills = new ArrayList<>();
                while (rb.next()) {
                    Document ReservationBillingDoc = new Document("BILLING_NUMBER", rb.getString("BILL_NUMBER"))
                            .append("TOTAL_PRICE", rb.getString("TOTAL_PRICE"))
                            .append("BILLDATE", rb.getString("BILLDATE"))
                            .append("C_EMAIL", rb.getString("C_EMAIL"));
                    reslistofbills.add(ReservationBillingDoc);
                }
                reservationDoc.append("BILLING", reslistofbills);
                rb.close();

                ResultSet rc = mariaDBQueries.getReservationCar(resevationnumber);
                List<Document> reslistofcars = new ArrayList<>();
                while (rc.next()) {
                    Document ReservationCarDoc = new Document("REGISTRATION_NUMBER", rc.getString("REGISTRATION_NUMBER"))
                            .append("CAR_MODEL", rc.getString("CAR_MODEL"))
                            .append("MODEL_YEAR", rc.getString("MODEL_YEAR"))
                            .append("DAILY_PRICE", rc.getString("DAILY_PRICE"));
                    reslistofcars.add(ReservationCarDoc);
                }
                reservationDoc.append("CAR", reslistofcars);
                rc.close();
                System.out.println(reservationDoc.toJson());
            }
            LOG.info("Reservation collection has created!");

         // mariaDBQueries.dropViews();
            st.close();
            rs.close();
            resQuery.close();
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

        try {
            maria.close();
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }

}
