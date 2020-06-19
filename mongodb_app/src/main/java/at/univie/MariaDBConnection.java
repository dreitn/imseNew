package at.univie;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.Statement;
import java.util.logging.Logger;


public class MariaDBConnection {
    private static final Logger LOG = Logger.getLogger(MariaDBConnection.class.getName());

    private String DB_CONNECTION_URL = "jdbc:mariadb://localhost:3306/db";
    private String USER = "user";
    private String PASS = "user";

    private static Statement stmt;
    private static Connection con;

    public MariaDBConnection() {
        try {
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
        LOG.info("Connected MariaDB successfully!!");

    }

    public String getDbConnectionUrl() {
        return DB_CONNECTION_URL;
    }

    public Statement getStmt() {
        return stmt;
    }

    public Connection getCon() {
        return con;
    }

    public void close() {
        try {
            stmt.close();
            con.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
