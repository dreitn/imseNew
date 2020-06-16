package at.univie;

import com.mongodb.*;
import com.mongodb.async.SingleResultCallback;
import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import org.bson.Document;

import java.util.Arrays;

public class Main {

    public static void main(String[] args) {

        MongoClient mongoClient = MongoClients.create("mongodb://root:example@localhost/");
        MongoDatabase database = mongoClient.getDatabase("admin");


        MongoCollection<Document> collection = database.getCollection("test");

        Document doc = new Document("name", "MongoDB")
                .append("type", "database")
                .append("count", 1)
                .append("versions", Arrays.asList("v3.2", "v3.0", "v2.6"))
                .append("info", new Document("x", 203).append("y", 102));

        collection.insertOne(doc);

    }




}
