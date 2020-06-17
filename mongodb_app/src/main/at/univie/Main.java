package at.univie;

import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import org.bson.Document;

import java.sql.*;
import java.util.logging.Logger;

public class Main {

    public static void main(String[] args) throws SQLException {

        Logger LOG = Logger.getLogger(Main.class.getName());
//Connect MongoDB
        MongoClient mongoClient = MongoClients.create("mongodb://root:example@localhost/");
        MongoDatabase database = mongoClient.getDatabase("admin");
//Connect MariaDB
        MariaDBConnection maria = new MariaDBConnection();
        Statement stmt  = maria.getStmt();
        Connection con = maria.getCon();
        LOG.info("Connected MAriaDB successfully!!");
//Create Collections first
        MongoCollection<Document> collectionCostumer = database.getCollection("Costumer");
        MongoCollection<Document> collectionReservation = database.getCollection("Reservation");

        LOG.info("Collections are set and we can start to migrate!!!");

        ResultSet costumersSet = stmt.executeQuery("Select * from Costumer");
        Statement CostumerStatement = con.createStatement();


        while (costumersSet.next()){
            Document doc = new Document("EMAIL", costumersSet.getString("EMAIL"))
                    .append("FIRSTNAME", costumersSet.getString("FIRSTNAME"))
                    .append("SURNAME", costumersSet.getString("SURNAME"))
                    .append("PHONE_NUMBER", costumersSet.getString("PHONE_NUMBER"))
                    .append("LOCATIONID", costumersSet.getString("LOCATIONID"));
            collectionCostumer.insertOne(doc);
        }




    }

}
