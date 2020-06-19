package at.univie;

import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import org.bson.Document;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Logger;

public class MongoDb {
    private final MongoClient mongoClient;
    private final MongoDatabase database;

    private static final Logger LOG = Logger.getLogger(MongoDb.class.getName());

    public MongoDb() {
        mongoClient = MongoClients.create("mongodb://root:example@localhost/");
        database = mongoClient.getDatabase("rent");
    }

    public void insertAllCostumers(ResultSet rs, MariaDBQueries mariaDBQueries) {

        MongoCollection<Document> collectionCostumer = database.getCollection("Costumer");

        try {
            while (rs.next()) {
                String email = rs.getString("EMAIL");
                String locationId = rs.getString("LOCATIONID");

                Document costumerDoc = new Document("email", rs.getString("EMAIL"))
                        .append("firstname", rs.getString("FIRSTNAME"))
                        .append("surname", rs.getString("SURNAME"))
                        .append("phone", rs.getString("PHONE_NUMBER"))
                        .append("location_id", rs.getString("LOCATIONID"));

                List<Document> listOfBills = new ArrayList<>();
                ResultSet bs = mariaDBQueries.getEmailByCostumerEmail(email);
                while (bs.next()) {
                    Document billingDoc = new Document("number", bs.getString("BILL_NUMBER"))
                            .append("total", bs.getString("TOTAL_PRICE"))
                            .append("date", bs.getString("BILLDATE"))
                            .append("email", bs.getString("C_EMAIL"));
                    listOfBills.add(billingDoc);

                }
                costumerDoc.append("Billing", listOfBills);

                ResultSet ls = mariaDBQueries.getLocationByLocationID(locationId);
                List<Document> listOfLocations = new ArrayList<>();
                while (ls.next()) {
                    Document locationDoc = new Document("location_id", ls.getString("LOCATION_ID"))
                            .append("zip_code", ls.getString("ZIP_CODE"))
                            .append("street", ls.getString("STREET"))
                            .append("city", ls.getString("CITY"));
                    listOfLocations.add(locationDoc);
                }
                costumerDoc.append("Location", listOfLocations);

                ResultSet fs = mariaDBQueries.getAreFriendsByCostumerEmail(email);
                List<Document> listOfAreFriends = new ArrayList<>();
                while (fs.next()) {
                    Document friendsDoc = new Document("email_friend", fs.getString("friend_costumer_email_2"));
                    listOfAreFriends.add(friendsDoc);
                }
                costumerDoc.append("Friend", listOfAreFriends);

                collectionCostumer.insertOne(costumerDoc);
            }
        } catch (SQLException sqlException) {
            sqlException.printStackTrace();
        }
        LOG.info("Costumer collection has created!");
    }

    public void inerstAllReservations(ResultSet resQuery, MariaDBQueries mariaDBQueries) {
        MongoCollection<Document> collectionReservation = database.getCollection("Booking");

        try {
            while (resQuery.next()) {
                String resevationbillnumber = resQuery.getString("RESERVATION_BILL_NUMBER");
                String resevationnumber = resQuery.getString("RESERVATION_NUMBER");

                Document reservationDoc = new Document("reservation_number", resQuery.getString("RESERVATION_NUMBER"))
                        .append("from_date", resQuery.getString("FROM_DATE"))
                        .append("to_date", resQuery.getString("RETURN_DATE"))
                        .append("amount", resQuery.getString("AMOUNT"));

                ResultSet rb = mariaDBQueries.getReservationBill(resevationbillnumber);
                List<Document> reslistofbills = new ArrayList<>();
                while (rb.next()) {
                    Document ReservationBillingDoc = new Document("bill_number", rb.getString("BILL_NUMBER"))
                            .append("total", rb.getString("TOTAL_PRICE"))
                            .append("date", rb.getString("BILLDATE"))
                            .append("email", rb.getString("C_EMAIL"));
                    reslistofbills.add(ReservationBillingDoc);
                }
                reservationDoc.append("Bill", reslistofbills);

                ResultSet rc = mariaDBQueries.getReservationCar(resevationnumber);
                List<Document> reslistofcars = new ArrayList<>();
                while (rc.next()) {
                    Document ReservationCarDoc = new Document("registration_number", rc.getString("REGISTRATION_NUMBER"))
                            .append("car_model", rc.getString("CAR_MODEL"))
                            .append("model_year", rc.getString("MODEL_YEAR"))
                            .append("daily_price", rc.getString("DAILY_PRICE"));
                    reslistofcars.add(ReservationCarDoc);
                }
                reservationDoc.append("Car", reslistofcars);

                collectionReservation.insertOne(reservationDoc);

            }

        } catch (SQLException sqlException) {
            sqlException.printStackTrace();
        }
        LOG.info("Reservation collection has created!");
    }

    public void insertAllCars(ResultSet rs) {
        MongoCollection<Document> collectionCars = database.getCollection("Cars");

        try {
            while (rs.next()) {
                Document carDoc = new Document("registration_number", rs.getString("REGISTRATION_NUMBER"))
                        .append("car_model", rs.getString("CAR_MODEL"))
                        .append("model_year", rs.getString("MODEL_YEAR"))
                        .append("daily_price", rs.getString("DAILY_PRICE"));
                collectionCars.insertOne(carDoc);
            }

        } catch (SQLException sqlException) {
            sqlException.printStackTrace();
        }
        LOG.info("Collection Cars has created!");

    }

    public void insertAllLocations(ResultSet rs) {
        MongoCollection<Document> collectionLocation = database.getCollection("Location");

        try {
            while (rs.next()) {
                Document locationDoc = new Document("location_id", rs.getString("LOCATION_ID"))
                        .append("zip_code", rs.getString("ZIP_CODE"))
                        .append("street", rs.getString("STREET"))
                        .append("city", rs.getString("CITY"));
                collectionLocation.insertOne(locationDoc);
            }


        } catch (SQLException sqlException) {
            sqlException.printStackTrace();
        }
        LOG.info("Collection Locations has created!");

    }
}
