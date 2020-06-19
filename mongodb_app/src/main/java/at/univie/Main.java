package at.univie;

import java.util.logging.Logger;

public class Main {

    public static void main(String[] args) {

        Logger LOG = Logger.getLogger(Main.class.getName());

        MariaDBConnection maria = new MariaDBConnection();
        MariaDBQueries mariaDBQueries = new MariaDBQueries(maria.getCon());

        MongoDb mongoDb = new MongoDb();
        mongoDb.insertAllCostumers(mariaDBQueries.getAllCostumers(), mariaDBQueries);
        mongoDb.inerstAllReservations(mariaDBQueries.getAllReservations(), mariaDBQueries);

        mongoDb.insertAllCars(mariaDBQueries.getAllCars());
        mongoDb.insertAllLocations(mariaDBQueries.getAllLocations());


        maria.close();

    }

}
