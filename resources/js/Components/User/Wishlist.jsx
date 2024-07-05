export default function Wishlist({ wishlists = [] }) {
  return (
    <div className="bg-white shadow-md rounded-lg p-6">
      <h2 className="text-2xl font-bold mb-4">My Wishlist</h2>
      {wishlists.length === 0 ? (
        <p>
          Your wishlist is empty,
          <br />
          add Something!
        </p>
      ) : (
        <ul>
          {wishlists.map((item) => (
            <>
              <li key={item.id} className="mb-2">
                {item.book.title} by {item.book.author}
              </li>
              <button className="text-red-500 hover:underline">remove</button>
            </>
          ))}
        </ul>
      )}
    </div>
  );
}
