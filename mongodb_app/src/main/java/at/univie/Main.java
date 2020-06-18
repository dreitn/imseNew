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

                ResultSet bs = mariaDBQueries.getEmailByCostumerEmail(email);
                while (bs.next()) {
                    Document billingDoc = new Document("BILLING_NUMBER", bs.getString("BILL_NUMBER"))
                            .append("TOTAL_PRICE", bs.getString("TOTAL_PRICE"))
                            .append("BILLDATE", bs.getString("BILLDATE"))
                            .append("C_EMAIL", bs.getString("C_EMAIL"));
                    costumerDoc.append("BILLING", billingDoc);
                }

                ResultSet ls = mariaDBQueries.getLocationByLocationID(locationId);
                while (ls.next()) {
                    Document locationDoc = new Document("LOCATION_ID", ls.getString("LOCATION_ID"))
                            .append("ZIP_CODE", ls.getString("ZIP_CODE"))
                            .append("STREET", ls.getString("STREET"))
                            .append("CITY", ls.getString("CITY"));
                    costumerDoc.append("LOCATIONS", locationDoc);
                }

                ResultSet fs = mariaDBQueries.getAreFriendsByCostumerEmail(email);
                while (fs.next()) {
                    Document friendsDoc = new Document("FRIENDS", fs.getString("friend_costumer_email_2"));

                    costumerDoc.append("FRIENDS", friendsDoc);
                }
                LOG.info("Costumer collection has created!");
             //   System.out.println(costumerDoc.toJson());
            }
//creating Reservation collection which includes insurance, car, bill
            while(resQuery.next()){

                String resevationbillnumber = resQuery.getString("RESERVATION_BILL_NUMBER");
                String resevationnumber = resQuery.getString("RESERVATION_NUMBER");

                Document reservationDoc = new Document("RESERVATION_NUMBER", resQuery.getString("RESERVATION_NUMBER"))
                        .append("FROM_DATE", resQuery.getString("FROM_DATE"))
                        .append("RETURN_DATE", resQuery.getString("RETURN_DATE"))
                        .append("AMOUNT", resQuery.getString("AMOUNT"));

                ResultSet rb = mariaDBQueries.getReservationBill(resevationbillnumber);
                while (rb.next()) {
                    Document ReservationBillingDoc = new Document("BILLING_NUMBER", rb.getString("BILL_NUMBER"))
                            .append("TOTAL_PRICE", rb.getString("TOTAL_PRICE"))
                            .append("BILLDATE", rb.getString("BILLDATE"))
                            .append("C_EMAIL", rb.getString("C_EMAIL"));
                    reservationDoc.append("BILLING", ReservationBillingDoc);
                }

                ResultSet rc = mariaDBQueries.getReservationCar(resevationnumber);
                while (rc.next()) {
                    //TODO
                }


                System.out.println(reservationDoc.toJson());
            }

         //   mariaDBQueries.dropViews();

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }



    }

}
