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


        String costumerQuerry = "SELECT * FROM COSTUMER";
        try {
            Statement st = con.createStatement();

            ResultSet rs = st.executeQuery(costumerQuerry);

            MariaDBQueries mariaDBQueries = new MariaDBQueries(st, con);


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

                System.out.println(costumerDoc.toJson());
                // collectionTest.insertOne(costumerDoc);
            }

            mariaDBQueries.dropViews();

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }



    }

}
