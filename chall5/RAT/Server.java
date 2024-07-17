import java.net.*;
import java.io.*;
import java.util.*;
 
public class Server
{
    //initialize socket and input stream
    private Socket          socket   = null;
    private ServerSocket    server   = null;
    private DataInputStream in       = null;
    private DataOutputStream out     = null;
 
    // constructor with port
    public Server(int port)
    {
        // starts server and waits for a connection
        try
        {
            server = new ServerSocket(port);
            System.out.println("Server started");
 
            System.out.println("Waiting for a client ...");
 
            socket = server.accept();
            System.out.println("Client accepted");
            
            //set cmd command
            Scanner myObj=new Scanner(System.in);
            String send = myObj.nextLine();
 
            // takes input from the client socket
            in = new DataInputStream(
                new BufferedInputStream(socket.getInputStream()));

            out = new DataOutputStream(socket.getOutputStream());

            String line = "";

            // reads message from client until "End!" is sent
            
            while (!line.equals("End!"))
            {
                try
                {
                    line = in.readUTF();
                    System.out.println(line);
                }
                catch(IOException i)
                {
                    System.out.println(i);
                    break;
                }
            }

            System.out.println(send);
            out.writeUTF(send);

            System.out.println("Closing connection");
 
            // close connection
            try {
                in.close();
                out.close();
                socket.close();
            }
            catch(IOException i) {
                System.out.println(i);
            }
        }
        catch(IOException i)
        {
            System.out.println(i);
        }
    }
 
    public static void main(String args[])
    {
        Server server = new Server(5000);
    }
}